<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
      <table border="0" cellpadding="0" cellspacing="0" class="wrapperBody" style="max-width:600px;border-radius:5px;margin: 0">
        <tbody>
        <tr>
          <td align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard"
                   style="background-color:#fff;">
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
                <td width="100%" style="background: #004B67" height="80" align="center" valign="middle" class="imgHero">
                  <section class="header">
                      <span class="font-20"
                            style="white-space:nowrap;color: white; font-weight: bold; text-transform: capitalize;font-size:16px">Đặt lại mật khẩu thành công</span>
                  </section>
                </td>
              </tr>

              <tr>
                <td style="padding-left:16px" align="center" valign="top"
                    class="containtTable ui-sortable">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
                    <tbody>
                    <tr>
                      <td style="padding-bottom: 20px;" align="left" valign="top" class="description">

                        <section class="content">
                          <p>Xin chào <b>{{$user['name']}}</b>,</p>
                          <p>Mật khẩu của bạn được đặt lại thành công vào <b>{{date("h:i A d/m/Y", strtotime($user['updated_at']))}}</b>.</p>
                          <p>Vì lý do bảo mật, chúng tôi sẽ đăng xuất tất cả các thiết bị. Để tiếp tục sử dụng Hegka, hãy tiến hành đăng nhập lại.</p>
                          <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton" style="">
                            <tbody>
                            <tr>
                              <td style="padding-top:20px;padding-bottom:20px" align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" align="center">
                                  <tbody>
                                  <tr>
                                    <td align="center">
                                      <div style="margin-bottom: 10px">👇</div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="width:220px"
                                        align="center" class="ctaButton">
                                      <a href="{{$link}}"
                                         style="display:inline-block;width:220px; padding: 20px 35px; font-weight: 600; border-radius: 6px; background-color: #004b67; color: white; outline: none; border: none; margin: auto; text-decoration: none;font-size: 16px"
                                         target="_blank" class="text font-20">
                                        Đăng Nhập
                                      </a>
                                    </td>
                                  </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                        </section>
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
