<?php
	if( !defined( 'ABSPATH' ) ) exit;
	$tmp = explode( 'wp-content', __FILE__ );
	$wp_path = $tmp[0];
	require_once( $wp_path . '/wp-load.php' );
	//if (strpos($_SERVER['HTTP_REFERER'], 'page=rb_svgicons') > 0 ) {
		$zip = new ZipArchive();
		$upload_dir = wp_upload_dir();
		$filename = $upload_dir['basedir'] . "/rbsvgi_export.zip";

		if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)!==TRUE) {
			exit("cannot open <$filename>\n");
		}

		$rootPath = $upload_dir['basedir'] . '/rb-svgicons/';

		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file) {
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath));
				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		global $wpdb;
		$out = array();
		$rbsvgi_tname = $wpdb->prefix . 'rbsvgi';
		$results = $wpdb->get_results("SELECT * FROM $rbsvgi_tname", ARRAY_A);
		$res_a = array();
		foreach ($results as $key => $value) {
			$res_a[$value['name']] = $value['atts'];
		}
		$out['rbsvgi_t'] = $res_a;
		$out['rbsvgi_o'] = get_option('rbsvgi');

		$zip->addFromString("rbsvgi.json", json_encode($out));
		$zip->close();

		header("Content-disposition: attachment;filename=\"rbsvgi_export.zip\"");
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($filename));
		readfile($filename);
//	}
	return;
?>