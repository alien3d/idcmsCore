<?php
class documentTrailClass {
	/**
	 * File Information
	 * @param string $filename
	 * @return mixed
	 */
	protected function fileExtension($filename)
	{
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}

	/**
	 * Remove File Extension
	 * @param string $filename
	 * @return mixed
	 */
	protected function removeExtension($filename) {
		return preg_replace('/(.+)\..*$/', '$1', $filename);
	}

	/**
	 * Document Audit Trail
	 * @param numeric $leafId
	 * @param string $path
	 * @param string $filename
	 */
	protected function createTrail($leafId,$path,$filename){
		/**
		 *	Define basic audit trail system...
		 * 	@params numeric $documentCategoryId = 3
		 **/
		$documentCategoryId =3;


		if($this->access('create') ==1 ) {
			$this->q->start();


			$sql = "INSERT INTO `document`
								(
									`documentCategoryId`,
									`leafId`,
									`documentTitle`,
									`documentDesc`,
									`documentPath`,
									`documentFilename`,
									`isNew`,
									`isActive`,
									`By`,
									`Time`
								)
						VALUES	(
									'".$documentCategoryId."',
									'".$leafId."',
									'".$filename."',
									'".$path."',
									'".$filename."',
									'".$filename."',
									'1',
									'1',
									'".$_SESSION['staffId']."',
									'".date("Y-m-d H:i:s")."'
								); ";
			$this->q->create($sql);
			$this->q->commit();

			if($this->q->execute=='fail') {
				echo json_encode(array("success"=>"false","message"=>$this->q->responce));
				exit();
			}

		} else {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
	}
}