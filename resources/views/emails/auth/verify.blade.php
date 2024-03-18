<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
          href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400&display=swap"
          rel="stylesheet">
  <title>Hegka</title>
  <style>
      .sub-header {
          background-color: #004B67;
          height: 80px;
      }

      .sub-header span {
          font-size: calc(12px + 6 * ((100vw - 320px) / 768));
          color: white;
          font-weight: bold;
          text-transform: capitalize;
      }

      .sub-header .locker-logo {
          background-color: white;
          padding: 8px;
          border-radius: 50%;
          height: 40px;
          position: relative;
      }

      .sub-header .locker-logo svg {
          display: inline;
          width: 20px;
          filter: invert(15%) sepia(98%) saturate(1887%) hue-rotate(176deg) brightness(94%) contrast(101%);
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
      }
  </style>
</head>
<body style="padding: 0;box-sizing: border-box;font-family: 'Roboto', sans-serif;background: #f9f9f9">
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="middle" height="100%" style="margin: auto; font-size: 16px"
       id="bodyTable">
  <tbody>
  <tr>
    <td id="bodyCell">
      <table border="0" cellpadding="0" cellspacing="0" class="wrapperBody" style="max-width:600px;border-radius:5px">
        <tbody>
        <tr>
          <td align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;">
              <tbody>
              <tr>
                <td style="background-color:#004B67;font-size:1px;line-height:8px;border-top-left-radius: 5px; border-top-right-radius: 5px;"
                    class="topBorder" height="8">
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td align="center" valign="middle" height="80" class="emailLogo">
                  <section class="header">
                    <div class="logo">
                      <img style="width: 150px; height: 40px; object-fit: contain;"
                           src="https://static.hegka.com/file/7da682cd671d4911aa4e49764bfb8d99" alt="">
                    </div>
                  </section>
                </td>
              </tr>
              <tr>
                <td align="center" valign="middle" class="imgHero" style="background-color: #004B67;height: 80px;">
                  <div class="font-20" style="color: white; font-weight: bold; text-transform: capitalize;font-size: 20px">Xác minh tài khoản</div>
                </td>
              </tr>
              <tr>
                <td style="padding:16px" align="center" valign="top" class="containtTable ui-sortable">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
                    <tbody>
                    <tr>
                      <td colspan="2">
                        <p>Xin chào <b>{{$item['name']}}</b>,</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <p>Cảm ơn bạn đã xác minh email công ty của bạn</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <p>Mã xác minh của bạn là: <b>{{$code}}</b></p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <p>Mã xác minh chỉ có hiệu lực trong 10 phút</p>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              
              <tr>
                @include('emails.footer-notify')
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  </tbody>
</table>
</body>
</html>
