    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <style type="text/css">
      #outlook a { padding: 0; }
      .ReadMsgBody { width: 100%; }
      .ExternalClass { width: 100%; }
      .ExternalClass * { line-height:100%; }
      body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
      table, td { border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
      img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
      p { display: block; margin: 13px 0; }
    </style>

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <style type="text/css">
      @media only screen and (max-width:480px) {
        @-ms-viewport { width:320px; }
        @viewport { width:320px; }
      }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">

    <style type="text/css">
      @media only screen and (min-width:480px) {
        .mj-column-per-100, * [aria-labelledby="mj-column-per-100"] { width:100%!important; }
      }
    </style>
    </head>
    <body style="background: #f1f1f1;">
      <div style="background-color:#f1f1f1;"><div style="margin:0 auto;max-width:600px;"><table cellpadding="0" cellspacing="0" style="font-size:1px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:1px;padding:20px 0px;"><div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
        <table cellpadding="0" cellspacing="0" style="background:#fff;" width="100%" border="0"><tbody><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;text-align:left;"><div style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">&nbsp;</div></td></tr><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;text-align:left;"><table cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="left" border="0"><tbody><tr><td style="width:150px;"><img alt="" height="auto" src="http://www.ulearnpro.com/img/logo.png" style="border:none;display:block;outline:none;text-decoration:none;width:100%;height:auto;" width="150"></td></tr></tbody></table></td></tr><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;"><p style="font-size:1px;margin:0 auto;border-top:4px solid #14bef0;width:100%;"></p></td></tr><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;text-align:left;"><div style="cursor:auto;color:#000000;font-family:helvetica;font-size:26px;font-weight:400;line-height:32px;">
        @yield('subject')
        </div></td></tr><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;text-align:left;"><div style="cursor:auto;color:#000000;font-family:Helvetica, Arial;font-size:15px;font-weight:200;line-height:24px;">
        @yield('content')

        <p>
          Warm regards,<br>
          {{ env('APP_NAME') }}<br>
          <a href="{{ url('') }}">{{ url('') }}</a><br>
          <img src="http://www.ulearnpro.com/img/logo.png" width="160px" style="margin-top: 5px;">
        </p>
        <p>Note: This is an auto generated email. If you are not the intended recipient please delete this email.</p>
          
    </div></td></tr><tr><td style="word-break:break-word;font-size:1px;padding:10px 25px;text-align:left;"><div style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">&nbsp;</div></td></tr></tbody></table>
    </div></td></tr></tbody></table></div><div style="margin:0 auto;max-width:600px;"><table cellpadding="0" cellspacing="0" style="font-size:1px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:1px;padding:20px 0px;"></td></tr></tbody></table></div></div>
</body>
</html>
