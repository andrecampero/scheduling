<!DOCTYPE html>
<html lang="pt-br">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>Scheduling</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		
		<style type="text/css">
	
				input {
					outline: none;
					border: none;
				}

				.wrap-input {
				  position: relative;
				  width: 100%;
				  z-index: 1;
				  margin-bottom: 10px;
				}

				.input {
				  font-size: 14px;
				  line-height: 1.5;
				  color: #666666;

				  display: block;
				  width: 100%;
				  background: #f8f8f8;
				  height: 50px;
				  border-radius: 25px;
				  padding: 0 30px 0 68px;
				}


				.symbol-input {
				  font-size: 15px;
				  display: -webkit-box;
				  display: -webkit-flex;
				  display: -moz-box;
				  display: -ms-flexbox;
				  display: flex;
				  align-items: center;
				  position: absolute;
				  border-radius: 25px;
				  bottom: 0;
				  left: 0;
				  width: 100%;
				  height: 100%;
				  padding-left: 35px;
				  pointer-events: none;
				 -webkit-transition: all 0.4s;
				  -o-transition: all 0.4s;
				  -moz-transition: all 0.4s;
				  transition: all 0.4s;
				}
		</style>
		
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
		<!--end::Web font -->

        <!--begin::Base Styles -->
		<link href="{{url('assets/app/media/img/logos/favicon.ico')}}" rel="sortcut icon" type="image/x-icon" />
		<link href="{{url('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/demo/default/base/scheduling.css')}}" rel="stylesheet" type="text/css" />

		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
			ga('create', 'UA-37564768-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body style="overflow:hidden;" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<div class="m-grid m-grid--hor m-grid--root m-page" style="position: absolute; margin: auto; width: 100%">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<h4>Scheduling</h4>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head"></div>
							{!! Form::open(['route' => 'authenticate', 'class' => 'm-login__form m-form']) !!}

								<div class="wrap-input " >
									<input class="input" type="text" name="login" placeholder="Login">
									<span class="symbol-input">
									<i class="fa fa-user" aria-hidden="true"></i>
									</span>
								</div>

								<div class="wrap-input" >
									<input class="input" type="password" name="password" placeholder="Senha">
									<span class="symbol-input">
										<i class="fa fa-lock" aria-hidden="true"></i>
									</span>
								</div>

								@if(session()->has('message'))
								<p class="btn-danger text-center">{{session()->get('message')}}</p>
								@endif

								<div class="m-login__form-action">
									<button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary" style="width:100%;">Login</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ url('assets/demo/default/base/scripts.bundle.js')}}"  type="text/javascript"></script>

		<!--end::Base Scripts -->

		<!--begin::Page Snippets -->
		<script src="{{ url('assets/snippets/custom/pages/user/login.js') }}" type="text/javascript"></script>

		<!--end::Page Snippets -->
	</body>

	<!-- end::Body -->
</html>
