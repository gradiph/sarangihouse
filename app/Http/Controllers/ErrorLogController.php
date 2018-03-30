<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErrorLogSetSessionRequest;
use App\Http\Requests\ErrorLogStoreRequest;
use Illuminate\Http\Request;
use App\ErrorLog;
use App\UserLog;
use Auth;
use DB;

class ErrorLogController extends Controller
{
    public function index()
    {
        return view('error_log.index');
    }

    public function store(ErrorLogStoreRequest $request)
    {
		DB::beginTransaction();

		//store data
        $log = ErrorLog::create([
			'created_at' => $request->created_at,
			'user_id' => $request->user_id,
			'description' => $request->description,
			'action' => $request->action,
			'errorThrown' => $request->errorThrown,
			'status' => $request->has('status') ? $request->status : 'Waiting',
		]);
		if($log)
		{
			//create log is success
			DB::commit();
			return 'success';
		}
		else
		{
			//create log is failed
			DB::rollBack();
			return 'failed';
		}
    }

    public function show(ErrorLog $error_log)
    {
		//get previous error
		$prev = ErrorLog::where('id', '<', $error_log->id)->max('id');

		//get next error
		$next = ErrorLog::where('id', '>', $error_log->id)->min('id');

		return view('error_log.show')->with([
			'error_log' => $error_log,
			'prev' => $prev,
			'next' => $next,
		]);
    }

    public function update(Request $request, ErrorLog $error_log)
    {
        DB::beginTransaction();

		//old data
		$before = $error_log->status;

		//update data
		$error_log->status = $request->status;

		if($error_log->save())
		{
			//create user log
			$log = UserLog::create([
				'created_at' => date('Y-m-d H:i:s'),
				'user_id' => Auth::id(),
				'description' => 'Error Log #' . $error_log->id . ': change status from ' . $before . ' to ' . $request->status,
			]);

			if($log)
			{
				goto success;
			}
		}

		//failed update
		DB::rollBack();
		return response()->json([
			'status' => 'fail',
			'alert_messages' => 'Terjadi kesalahan.',
		]);

		//success update
		success:
		DB::commit();
		return response()->json([
			'status' => 'success',
			'alert_type' => 'alert-success',
			'alert_title' => 'Success!',
			'alert_messages' => 'Change status to ' . $request->status . '.',
		]);
    }

	public function dataList(Request $request)
	{
		//set session
		session(['error_log_search' => $request->has('ok_search') ? $request->search : session('error_log_search', '')]);
		session(['error_log_type_order' => $request->has('ok_order') ? $request->type_order : session('error_log_type_order', 'created_at')]);
		session(['error_log_value_order' => $request->has('ok_order') ? $request->value_order : session('error_log_value_order', 'desc')]);
		session(['error_log_limit' => $request->has('ok_limit') ? $request->limit : session('error_log_limit', '6')]);
		session(['error_log_status' => $request->has('ok_status') ? $request->status : session('error_log_status', 'Waiting')]);

		//fetch data
		$error_logs = ErrorLog::whereHas('user', function($query) {
			$query->where('name', 'like', '%'.session('error_log_search').'%');
		})
			->orWhere('description', 'like', '%'.session('error_log_search').'%')
			->orderBy(session('error_log_type_order'), session('error_log_value_order'));

		//filter status
		if(session('error_log_status') == 'Waiting') $error_logs->where('status', 'Waiting');
		elseif(session('error_log_status') == 'Process') $error_logs->where('status', 'Process');
		elseif(session('error_log_status') == 'Clear') $error_logs->where('status', 'Clear');

		return view('error_log.list')->with([
			'error_logs' => $error_logs->paginate(session('error_log_limit')),
		]);
	}

	public function setSessionPost(ErrorLogSetSessionRequest $request)
	{
		session(['error_log_'.$request->type => $request->value]);

		return session('error_log_'.$request->type) == $request->value;
	}

	public function resetList()
	{
		session(['error_log_name' => '']);

		return redirect()->action('ErrorLogController@dataList');
	}
}
