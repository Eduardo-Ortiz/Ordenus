<?php

namespace App\Http\Controllers\Admin;

use App\Equivalence;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquivalencesController extends Controller
{
    public function getFromUnit(Unit $unit)
    {
        //
        return $unit->equivalences()->join('units', 'units.id', '=', 'equivalences.to_id')->get();
    }


    public function getAvailableEquivalences(Unit $unit)
    {
        $filter = $unit->equivalences()->pluck('to_id')->toArray();
        array_push($filter, $unit->id);

        return Unit::whereNotIn('id', $filter)->get();
    }

    public function store(Request $request)
    {
        $from_equivalences = Unit::find(request('from_id'))->equivalences()->get();



        $to_equivalences = Unit::find(request('to_id'))->equivalences();

        $first = Equivalence::create([
            'from_id'=> request('from_id'),
            'to_id'=> request('to_id'),
            'ratio' => request('ratio')
        ]);

        $second = Equivalence::create([
            'from_id'=> request('to_id'),
            'to_id'=> request('from_id'),
            'ratio' => (1/request('ratio'))
        ]);

        foreach($from_equivalences as $equivalence)
        {
            Equivalence::create([
                'from_id'=> $equivalence->to_id,
                'to_id'=> $first->to_id,
                'ratio' => 1/($equivalence->ratio/request('ratio'))
            ]);

            Equivalence::create([
                'from_id'=> $first->to_id,
                'to_id'=> $equivalence->to_id,
                'ratio' => $equivalence->ratio/request('ratio')
            ]);
        }

    }


    public function destroy(Request $request)
    {
        Equivalence::where('from_id', '=', request('from_id'))
            ->where('to_id', '=', request('to_id'))
            ->first()->delete();

        Equivalence::where('from_id', '=', request('to_id'))
            ->where('to_id', '=', request('from_id'))
            ->first()->delete();
    }
}
