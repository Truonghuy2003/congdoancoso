namespace App\Helpers;

class Helper {
    public static function LayHinhDauTien($strNoiDung) {
        $first_img = '';
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strNoiDung, $matches);
        return empty($matches[1]) ? asset('public/img/noimage.png') : str_replace('&amp;', '&', $matches[1][0]);
    }
}
