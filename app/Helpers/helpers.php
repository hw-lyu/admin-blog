<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('file_s3_upload')) {

    /**
     * S3 파일 스토리지 업로드
     *
     * @param array $nowFiles 클라이언트에 현재 업로드 되있는 파일들
     * @param array $requestFiles 요청된 업로드될 파일들
     * @param string $path 파일경로
     *
     * @return array
     */
    function file_s3_upload(array $nowFiles, array $requestFiles, string $path): array
    {
        foreach ($requestFiles as $name => $file) {
            $fileName = "{$path}/{$name}_" . now()->format('Ymdhisu') . ".{$file->extension()}";

            $nowFiles[$name]["{$name}_path"] = $fileName;

            Storage::disk('s3')->put($fileName, $file->getContent());

            $blogFile = new \App\Models\BlogFile;
            $blogFile->file_name = str_replace($path.'/', '', $fileName);
            $blogFile->file_path = $fileName;
            $blogFile->file_size = $file->getSize();
            $blogFile->file_mine = $file->getMimeType();
            $blogFile->created_at = now();

            $blogFile->save();

            $nowFiles[$name]['id'] = $blogFile->id;
        }

        return $nowFiles;
    }
}
