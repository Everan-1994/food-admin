<?php

namespace App\Admin\Controllers;


trait ScriptTrait
{
    public function script()
    {
        return <<<EOT

            $(document).ready(() => {
                $('.kv-file-content').each((i, e) => {
                    var url = $(e).find('img').attr('src');
                    var _url = url.split('/');
                    var file = _url[_url.length - 1].split('.');
                    if (file[1] == 'mp4') {
                        $(e).find('img').remove();
                        var video = '<video class="kv-preview-data file-preview-video" controls="" style="width:213px;height:160px;">';
                            video += '<source src="'+ url +'" type="video/mp4">';
                            video += '</video>'
                            
                        $(e).append(video);
                    }
                });
            })
EOT;

    }

    public function removeCancelButton()
    {
        return <<<EOT

            $(document).ready(() => {
                $('.fileinput-cancel-button').css('display', 'none')
            })
EOT;
    }

    public function addTips($label, $w, $h)
    {
        return <<<EOT

            $(document).ready(() => {
                let dom = $('label[for={$label}]')
                let html = dom.html()
                let _html = html + '<br><span style="color: red;font-size: 12px;">('+ {$w} + '*' + {$h} +')</span>'
                dom.html(_html)
            })
EOT;
    }

    public function addTextTips($label, $text)
    {
        return <<<EOT

            $(document).ready(() => {
                let dom = $('label[for={$label}]')
                let html = dom.html()
                let _html = html + '<br><span style="color: red;font-size: 12px;">{$text}</span>'
                dom.html(_html)
            })
EOT;
    }

}