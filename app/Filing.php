<?php

namespace App;
use Illuminate\Support\Facades\DB;

class Filing {

    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function get_return_id(){
        return $this->get_data_value('RETURN_ID');
    }

    public function get_filing_type(){
        return $this->get_data_value('FILING_TYPE');
    }

    public function get_ein(){
        return $this->get_data_value('EIN');
    }

    public function get_tax_period(){
        return $this->get_data_value('TAX_PERIOD');
    }

    public function get_sub_date(){
        return $this->get_data_value('SUB_DATE');
    }

    public function get_taxpayer_name(){
        return $this->get_data_value('TAXPAYER_NAME');
    }

    public function get_return_type(){
        return $this->get_data_value('RETURN_TYPE');
    }

    public function get_dln(){
        return $this->get_data_value('DLN');
    }

    public function get_object_id(){
        return $this->get_data_value('OBJECT_ID');
    }

    public function get_aws_file_link(){

        $object_id = $this->get_object_id();

        if ($object_id){
            return "https://s3.amazonaws.com/irs-form-990/{$object_id}_public.xml";
        }

    }

    ///////////////
    // Protected //
    ///////////////

    protected function get_data_value($key){

        if (isset($this->data) && isset($this->data->$key)){
            return $this->data->$key;
        }

    }

    ////////////
    // Static //
    ////////////

    public static function search_by_name($search){

        $search = strtoupper($search);

        $results = DB::table('filings')
                    ->where('TAXPAYER_NAME', 'like', '%' . $search . '%')
                    ->orderby('TAXPAYER_NAME')
                    ->limit(500)
                    ->get();

        $items = array();

        foreach ($results as $result){
            $classname = get_called_class();
            $items[] = new $classname($result);
        }

        return $items;

    }

}
