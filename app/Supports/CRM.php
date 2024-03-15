<?php

namespace App\Supports;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CRM
{
    public static final function strToSlug($str)
    {
        // replace non letter or digits by -
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);

        // transliterate
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);

        // remove unwanted characters
        $str = preg_replace('~[^-\w]+~', '', $str);

        // trim
        $str = trim($str, '-');

        // remove duplicate -
        $str = preg_replace('~-+~', '-', $str);

        // lowercase
        $str = strtolower($str);

        if (empty($str)) {
            return 'n-a';
        }

        return $str;
    }

    public static final function generateUniqueCode($table, $column, $min = 100000, $max = 99999999)
    {
        do {
            $code = random_int($min, $max);
        } while (DB::table("$table")->where("$column", $code)->first());

        return $code;
    }

    public static final function genCode($table, $column, $length = 10)
    {
        $key = Str::random($length);
        $item = DB::table("$table")->where("$column", $key)->first();
        if ($item) {
            self::genCode($table, $column, $length);
        }
        return $key;
    }

    public static final function getUrl($string)
    {
        preg_match_all('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.~]*(\?\S+)?)?)*)@', $string, $match);
        return $match;
    }

    public static final function file_get_contents_curl($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static final function getUrlData($url)
    {
        $result = false;
        try {
            $url = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.~]*(\?\S+)?)?)*)@', '$1', $url);
            if (strpos($url, "http") === false) {
                $url = "http://$url";
            }

            $host = parse_url($url);

            $contents = self::file_get_contents_curl($url);
            if (isset($contents) && is_string($contents)) {
                $title = null;
                $metaTags = null;

                preg_match('/<title>([^>]*)<\/title>/si', $contents, $match);

                if (isset($match) && is_array($match) && count($match) > 0) {
                    $title = strip_tags($match[1]);
                }

                $pattern = '
                          ~<\s*meta\s

                          # using lookahead to capture type to $1
                            (?=[^>]*?
                            \b(?:name|property|http-equiv)\s*=\s*
                            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
                            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
                          )

                          # capture content to $2
                          [^>]*?\bcontent\s*=\s*
                            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
                            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
                          [^>]*>

                          ~ix';

                if (preg_match_all($pattern, $contents, $out)) {
                    $metaTags = array_combine($out[1], $out[2]);
                }

                $result = array(
                    'title'    => $title,
                    'metaTags' => $metaTags,
                    'host'     => Arr::get($host, 'host')
                );
            }
        } catch (\Exception $exception) {
            $host = parse_url($url);
            $result = array(
                'host'  => Arr::get($host, 'path'),
                'title' => 'Page not found - ' . strtoupper(Arr::get($host, 'path')),
            );
            return $result;
        }

        return $result;
    }

    public static final function imageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }

    public static final function encryptString($plaintext, $password, $encoding = null)
    {
        $iv = openssl_random_pseudo_bytes(16);
        $ciphertext = openssl_encrypt($plaintext, "AES-256-CBC", hash('sha256', $password, true), OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext . $iv, hash('sha256', $password, true), true);
        return $encoding == "hex" ? bin2hex($iv . $hmac . $ciphertext) : ($encoding == "base64" ? base64_encode($iv . $hmac . $ciphertext) : $iv . $hmac . $ciphertext);
    }

    public static final function decryptString($ciphertext, $password, $encoding = null)
    {
        $ciphertext = $encoding == "hex" ? hex2bin($ciphertext) : ($encoding == "base64" ? base64_decode($ciphertext) : $ciphertext);
        if (!hash_equals(hash_hmac('sha256', substr($ciphertext, 48) . substr($ciphertext, 0, 16), hash('sha256', $password, true), true), substr($ciphertext, 16, 32))) return null;
        return openssl_decrypt(substr($ciphertext, 48), "AES-256-CBC", hash('sha256', $password, true), OPENSSL_RAW_DATA, substr($ciphertext, 0, 16));
    }


    public static final function allImageMimeTypes()
    {
        return [
            'image/apng',
            'image/avif',
            'image/bmp',
            'image/cgm',
            'image/dicom-rle',
            'image/emf',
            'image/fits',
            'image/g3fax',
            'image/gif',
            'image/heic',
            'image/heic-sequence',
            'image/heif',
            'image/heif-sequence',
            'image/hej2k',
            'image/hsj2k',
            'image/ief',
            'image/jls',
            'image/jp2',
            'image/jpeg',
            'image/jph',
            'image/jphc',
            'image/jpm',
            'image/jpx',
            'image/jxr',
            'image/jxra',
            'image/jxrs',
            'image/jxs',
            'image/jxsc',
            'image/jxsi',
            'image/jxss',
            'image/ktx',
            'image/png',
            'image/sgi',
            'image/svg+xml',
            'image/t38',
            'image/tiff',
            'image/tiff-fx',
            'image/vnd.adobe.photoshop',
            'image/vnd.airzip.accelerator.azv',
            'image/vnd.dece.graphic',
            'image/vnd.djvu',
            'image/vnd.dvb.subtitle',
            'image/vnd.dwg',
            'image/vnd.dxf',
            'image/vnd.fastbidsheet',
            'image/vnd.fpx',
            'image/vnd.fst',
            'image/vnd.fujixerox.edmics-mmr',
            'image/vnd.fujixerox.edmics-rlc',
            'image/vnd.globalgraphics.pgb',
            'image/vnd.microsoft.icon',
            'image/vnd.mix',
            'image/vnd.ms-modi',
            'image/vnd.mozilla.apng',
            'image/vnd.net-fpx',
            'image/vnd.radiance',
            'image/vnd.sealed.png',
            'image/vnd.sealedmedia.softseal.gif',
            'image/vnd.sealedmedia.softseal.jpg',
            'image/vnd.svf',
            'image/vnd.tencent.tap',
            'image/vnd.valve.source.texture',
            'image/vnd.wap.wbmp',
            'image/vnd.xiff',
            'image/vnd.zbrush.pcx',
            'image/webp',
            'image/wmf',
            'image/x-3ds',
            'image/x-cmu-raster',
            'image/x-cmx',
            'image/x-freehand',
            'image/x-icon',
            'image/x-jng',
            'image/x-mrsid-image',
            'image/x-nikon.nef',
            'image/x-pcx',
            'image/x-pict',
            'image/x-portable-anymap',
            'image/x-portable-bitmap',
            'image/x-portable-graymap',
            'image/x-portable-pixmap',
            'image/x-rgb',
            'image/x-tga',
            'image/x-xbitmap',
            'image/x-xpixmap',
            'image/x-xwindowdump'
        ];
    }

    public static final function allImageMimeTypeString()
    {
        return implode(',', self::allImageMimeTypes());
    }

    public static final function clean(array $data)
    {
        foreach ($data as $i => $row) {
            if ('null' === $row) {
                $data[$i] = null;
            }
        }
        return $data;
    }
}
