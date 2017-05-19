<?php
	/**
	 * Created by PhpStorm.
	 * User: boing
	 * Date: 14/02/2017
	 * Time: 15:17
	 */

	namespace Plugin\KbWidgets\Setup;


	use Ip\Exception;
    use Plugin\KbCore\Helper;

    class Worker
	{
		public function activate()
		{
		    try{
		        if(Helper::isCore()){
                    DB::install();
                }
            }catch (Exception $e){
		        echo $e->getMessage();
            }

		}

		public function deactivate()
		{

		}

		public function remove()
		{

		}
	}