<?php

namespace Backpack\CRUD\app\Http\Controllers;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin')     => backpack_url('dashboard'),
            trans('backpack::base.dashboard') => false,
        ];
		
		// Graph 1
		$lenderNameData00 = $lenderNameData01 = $lenderNameData1 = array();
		
		$lenderData = \DB::table('lender_banking')->leftJoin('lenders', 'lender_banking.lender_id', '=', 'lenders.id')->selectRaw('lenders.name, SUM(lender_banking.sanction_amount) as total_sanction, SUM(lender_banking.outstanding_amount) as total_outstanding')->groupBy('lender_id')->get(); //SELECT FROM `lender_banking` lb LEFT join lenders l ON lb.lender_id = l.id GROUP BY lender_id
		//exit;
		//dd($lenderData);
		if($lenderData)
		{
			foreach($lenderData as $k => $row)
			{
				if($row->total_sanction > 0 && $row->total_outstanding > 0)
				{
					$lenderNameData00[] = (float)$row->total_sanction;
					$lenderNameData01[] = (float)$row->total_outstanding;
					$lenderNameData[] = array('name' => $row->name, 'data' => [(float)$row->total_sanction, (float)$row->total_outstanding]);
					$lenderNameData1[] = $row->name;
				}
			}
		}
		
		$chart1 = \Chart::title([
			'text' => 'Lender Banking',
		])
		->chart([
			'type'     => 'column', // pie , columnt ect
			'renderTo' => 'first_chart', // render the chart into your div with id
		])
		->subtitle([
			'text' => '',
		])
		->colors([
		])
		->credits([
			'enabled' => 'false'
		])
		->xaxis([
			'categories' => $lenderNameData1,
			'labels'     => [
				'rotation'  => 15,
				'align'     => 'top',
				'enabled' => true,
				
				// use 'startJs:yourjavasscripthere:endJs'
			],
		])
		->yaxis([
			'title'     => [
				'enabled' => true,
				'text' => 'Data'
			],
		])
		->legend([
			'layout'        => 'vertical',
			'align'         => 'right',
			'verticalAlign' => 'middle',
		])
		->series(
			[
				[
					'name'  => 'Sanction',
					'data'  => $lenderNameData00,
				],
				[
					'name'  => 'Outstanding',
					'data'  => $lenderNameData01,
				],
			]
		)
		->display(0);
		
		$this->data['chart1'] = $chart1;
		
		// Graph 2
		$lastMonth = $docData = $lenderData = array();
		for($i=0;$i<=11;$i++)
		{
			$lastMonth[] = date('M-Y', strtotime('-'.$i.' months'));
			
			$month = date('m', strtotime('-'.$i.' months'));
			$year = date('Y', strtotime('-'.$i.' months'));
			
			$total_doc = 0;
			$docRowData = \DB::table('documents')->selectRaw('COUNT(id) as total_doc, YEAR(expiry_date) year, MONTH(expiry_date) month')->whereMonth('expiry_date', '=', $month)->whereYear('expiry_date', '=', $year)->groupby('year','month')->first();
			if($docRowData)
			{
				$total_doc = $docRowData->total_doc;
			}
			
			$docData[] = $total_doc;
			
			$total_lender = 0;
			$docRowData = \DB::table('lenders')->selectRaw('COUNT(id) as total_lender, YEAR(created_at) year, MONTH(created_at) month')->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->groupby('year','month')->first();
			if($docRowData)
			{
				$total_lender = $docRowData->total_lender;
			}
			
			$lenderData[] = $total_lender;
		}
		//dd($docData);
		
		$chart2 = \Chart::title([
			'text' => 'Document',
		])
		->chart([
			'type'     => 'line', // pie , columnt ect
			'renderTo' => 'second_chart', // render the chart into your div with id
		])
		->subtitle([
			'text' => '',
		])
		->colors([
		])
		->credits([
			'enabled' => 'false'
		])
		->xaxis([
			'categories' => $lastMonth
		])
		->yaxis([
			'title'     => [
				'enabled' => true,
				'text' => 'Document Published'
			],
		])
		->legend([
			'layout'        => 'vertical',
			'align'         => 'right',
			'verticalAlign' => 'middle',
		])
		->plotOptions([
			'line' => [
				'dataLabels' => [
					'enabled' => 'true'
				],
				'enableMouseTracking' => 'false'
			]
		])
		->series(
			[
				[
					'name'  => 'Doc',
					'data'  => $docData,
				]
			]
		)
		->display();
		
		$this->data['chart2'] = $chart2;
		
		// Graph 1
		$categories1 = array();
		
		$chart3 = \Chart::title([
			'text' => 'Lenders',
		])
		->chart([
			'type'     => 'line', // pie , columnt ect
			'renderTo' => 'third_chart', // render the chart into your div with id
		])
		->subtitle([
			'text' => '',
		])
		->colors([
		])
		->credits([
			'enabled' => 'false'
		])
		->xaxis([
			'categories' => $lastMonth
		])
		->yaxis([
			'title'     => [
				'enabled' => true,
				'text' => 'Lender Registered'
			],
		])
		->legend([
			'layout'        => 'vertical',
			'align'         => 'right',
			'verticalAlign' => 'middle',
		])
		->plotOptions([
			'line' => [
				'dataLabels' => [
					'enabled' => 'true'
				],
				'enableMouseTracking' => 'false'
			]
		])
		->series(
			[
				[
					'name'  => 'Lender',
					'data'  => $lenderData,
				]
			]
		)
		->display();
		
		$this->data['chart3'] = $chart3;

        return view(backpack_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
