<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Home()
    {
        return view('home');
    }

    public function getStudents()
    {
        $students = DB::select("
            /*traz todo mundo por regiao*/
                SELECT
                    gpNao.regional,
                    SUM(gpSim.resSim / gpNao.resNao) * 100 AS total
                FROM
                    (
                    SELECT
                        alt.description,
                        stud.regional,
                        COUNT(stud.regional) AS resSim
                    FROM
                        students stud,
                        alternatives alt,
                        answers awns,
                        questions quest
                    WHERE
                        alt.description = 'sim' AND awns.student_id = stud.id AND quest.id = awns.question_id AND awns.alternative_id = alt.id
                    GROUP BY
                        stud.regional
                ) gpSim,
                (
                SELECT
                    alt.description,
                    stud.regional,
                    COUNT(stud.regional) AS resNao
                FROM
                    students stud,
                    alternatives alt,
                    answers awns,
                    questions quest
                WHERE
                    alt.description = 'nao' AND awns.student_id = stud.id AND quest.id = awns.question_id AND awns.alternative_id = alt.id
                GROUP BY
                    stud.regional
                ) gpNao
                GROUP BY
                    gpSim.regional,
                gpNao.regional
        ");

        $national = DB::select("
            SELECT sum(a.total) / count(a.regional) as nacional  from 
                (SELECT
                    gpNao.regional,
                    SUM(gpSim.resSim / gpNao.resNao) * 100 AS total
                FROM
                    (
                    SELECT
                        alt.description,
                        stud.regional,
                        COUNT(stud.regional) AS resSim
                    FROM
                        students stud,
                        alternatives alt,
                        answers awns,
                        questions quest
                    WHERE
                        alt.description = 'sim' AND awns.student_id = stud.id AND quest.id = awns.question_id AND awns.alternative_id = alt.id
                    GROUP BY
                        stud.regional
                ) gpSim,
                (
                SELECT
                    alt.description,
                    stud.regional,
                    COUNT(stud.regional) AS resNao
                FROM
                    students stud,
                    alternatives alt,
                    answers awns,
                    questions quest
                WHERE
                    alt.description = 'nao' AND awns.student_id = stud.id AND quest.id = awns.question_id AND awns.alternative_id = alt.id
                GROUP BY
                    stud.regional
                ) gpNao
                GROUP BY
                    gpSim.regional,
                    gpNao.regional) a
        ");

        $objectData = [
            'regionals' => []
        ];

        foreach ($students as $key => $student) {
            array_push($objectData['regionals'], array(
                'description' => $student->regional,
                'average'     => $student->total
            ));
        };

        $objectData['national'] = $national[0]->nacional;

        return json_encode($objectData);
    }
}
