<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        
        $startTimeDate = $this->input('start_time_date');
        $startTimeTime = $this->input('start_time_time');
        $endTimeDate = $this->input('end_time_date');
        $endTimeTime = $this->input('end_time_time');
        $startTime = '';
        $endTime = '';
        $diffInputTime = 0;

        $startyear = 0;
        $startmonth = 0;
        $startday = 0;
        $endyear = 0;
        $endmonth = 0;
        $endday = 0;

        $startTimeDateList = explode('-', $startTimeDate);
        $endTimeDateList = explode('-', $endTimeDate);

        if(count($startTimeDateList)==3){
            if(is_numeric($startTimeDateList[0])&&is_numeric($startTimeDateList[1])&&is_numeric($startTimeDateList[2])){
                $startyear = $startTimeDateList[0];
                $startmonth = $startTimeDateList[1];
                $startday = $startTimeDateList[2];
            }
        }
        if(count($endTimeDateList)==3){
            if(is_numeric($endTimeDateList[0])&&is_numeric($endTimeDateList[1])&&is_numeric($endTimeDateList[2])){
                $endyear = $endTimeDateList[0];
                $endmonth = $endTimeDateList[1];
                $endday = $endTimeDateList[2];
            }
        }

        if(checkdate( $startmonth, $startday,$startyear) && checkdate($endmonth, $endday,$endyear)){
            $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
            $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);
        }

        if($startTime!=''&&$endTime!=''){
            $diffInputTime = $endTime->diffInMinutes($startTime);
        }

        $this->merge(['start_time' =>$startTime]);
        $this->merge(['end_time' =>$endTime]);
        $this->merge(['diff_input_time' =>$diffInputTime]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $validate_func = function($attribute, $value, $fail) {
            // 入力の取得
            $input_data = $this->all();

            // 条件に合致しなかったら失敗にする
            if($input_data['end_time']<=$input_data['start_time']){
                $fail('終了時刻は開始時刻以降の日時を入力してください。.');
            }
            if($input_data['diff_input_time']<=5){
                $fail('開始時刻と終了時刻の差は5分より多く必要です。.');
            }
        };
        return [
            'movie_id' => ['required'],
            'screen_id' => ['required','gte:1'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i',$validate_func],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i',$validate_func],
        ];
    }

    //validationでエラーがあった時のエラーメッセージを以下で生成する。
    public function messages()
    {
        return [
            'screen_id.gte' => 'スクリーンを選択してください。', 
            // 'diff_input_time.gt' => '開始時刻と終了時刻の差は5分より多く必要です。', 
        ];
    }
}
