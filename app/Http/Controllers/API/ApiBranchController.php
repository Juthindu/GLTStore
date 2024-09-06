<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchPhone;
use Exception;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class ApiBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branches = Branch::query();

        if ($keyword = $request->get('keyword')) {
            $branches->where('name', 'like', "%{$keyword}%")
                ->orWhere('address', 'like', "%{$keyword}%")
                ->orWhere('code', 'like', "%{$keyword}%");
        }

        $branches->with('phones');

        if ($limit = $request->get('limit')) {
            return response()->json($branches->paginate($limit), 200);
        }
        return response()->json($branches->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'code' => ['required', 'unique:branches'],
            'phones' => ['array'],
            'phones.*.type' => ['required'],
            'phones.*.number' => ['required', 'unique:branch_phones', 'digits:10', 'numeric']

        ], [
            'phones.*.type.required' => "Phone number type cannot be empty.",
            'phones.*.number.required' => "Phone number cannot be empty.",
            'phones.*.number.numeric' => "Phone number can only contains numerals.",
            'phones.*.number.digits' => "Invalid phone number length, 10 digits.",
            'phones.*.number.unique' => "Phone number is already in use.",
        ]);
        $branch = Branch::create($validatedData);

        foreach ($validatedData['phones'] as $phone) {

            $branch->phones()->create(
                [
                    'type' => $phone['type'],
                    'number' => $phone['number']
                ]
            );
        }

        if (!$branch) return response()->json(['message' => 'Failed to create the branch, please try again!'], 500);
        return response()->json(["message" => "Branch created successfully!", "branch" => $branch], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = Branch::find($id);
        if (is_null($branch)) return response()->json(['message' => "No record found!"], 404);
        return response()->json($branch, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'code' => ["unique:branches,code,{$id}"],
            'phones' => ['array'],
            'phones.*.type' => ['required'],
            'phones.*.number' => ['required', "unique:branch_phones,number,{$id}", 'digits:10', 'numeric']

        ], [
            'phones.*.type.required' => "Phone number type cannot be empty.",
            'phones.*.number.required' => "Phone number cannot be empty.",
            'phones.*.number.numeric' => "Phone number can only contains numerals.",
            'phones.*.number.digits' => "Invalid phone number length, 10 digits.",
            'phones.*.number.unique' => "Phone number is already in use.",
        ]);

        $branch = Branch::find($id);
        if (is_null($branch)) return response()->json(['message' => "No record found to update!"], 404);

        $branch->update($validatedData);

        // Update the phone numbers
        foreach ($validatedData['phones'] as $phone) {

            BranchPhone::firstOrCreate([
                'branch_id' => $branch->id,
                'number' => $phone['number']
            ], [
                'type' => $phone['type'],
            ]);
        }

        if (!$branch) return response()->json(['message' => 'Failed to update the record, please try again!'], 500);
        return response()->json(['message' => 'Record updated successfully!', 'branch' => $branch], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {

            if ($only = $request->get('only')) {
                switch ($only) {
                    case 'number':

                        $number = BranchPhone::find($id);
                        if (is_null($number)) return response()->json(['message' => 'No record found!'], 404);
                        $number->delete();
                        return response()->json(['message' => 'Branch number deleted successfully!'], 200);

                    default:
                        return response()->json(['message' => "Invalid ONLY type parameter!"], 400);
                }
            }

            $branch = Branch::find($id);
            if (is_null($branch)) return response()->json(['message' => "No record found!"], 404);

            $branch->delete();
            if (!$branch) return response()->json(['message' => 'Failed to delete the branch, please try again!'], 500);

            return response()->json(['message' => 'Branch deleted successfully!'], 200);
        } catch (Exception $e) {
            return $e;
        }
    }
}
