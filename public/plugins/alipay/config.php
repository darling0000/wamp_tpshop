<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091300503878",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEA5UPto1ymJxWDLp9bRe590YsKQqHTGXaHewGbPZKjED8nQUuku5gvet94qKNj2rhsXvS8y8jgHYa3H3zq+dCFBMnZl64uO/VBWjIBoExv2opoBAYvbxxV8+uFtKbkhbYjbRv18AK/ZXtd/kF/0GhjZsBBg4RakRCTelNpL3qzkQXukWDVMwqEJqN85YZ3ZKCreHOD+kU/clyxSaXeEmmxLtt7v1OapCd3l/ZrBXhYXM5T7Zw+6GUgtRMhGAYWd3dGmZkuJP9JRI2jsKTjx3Zr6GZ+uxOC+XzCpzAfolRwafgk42+3cMUCGYVDJNkXwJzPQpHmayKtSe2zzpcYMZFrVQIDAQABAoIBAGIR9ptEzIY3e4/79s0pQYTbFx59npFr1HRXsZJbIYmXmjEiLGtapCTJZxGsItCyxxivU/tQCB5ZPAgqJVGLUvtDZOKvTXO0a6orbeqmB8rSHcBq7Ot4kYPvoZgvM93Glczcgw2R/1FnvkM+vW/m125imyOpABzBnHRdLcdzk1BbC/hbGwoWenh660hj02aUfoUivi28OHbduzP37IgoO/hi5tM7qEOU39PoSYaluisfeyoSY0cPj2PDnxPx486mHUfTjN5oF8lo5nULrR3Gafiyk1VEcMQYMWs4G+0jmCUcKUAa3gTPNZEXSMR6N0rR3+Fs6tADQiO0DsCFeO4Il8ECgYEA8mB/olPl+aNIjgm6wV1JUZP6tZs629NOJINosM5iJm+aN5rwuWZX+u5Jm/rxCCqbc0Oof4Ey9aJ/QKT+ugM2r961YBbj7wo8sV5+iE9fjIt6rP5t56WkHJfdiU9EzPlTFAxlmSASsHOJb91BbACdKZMOX6clf90dHKUj2xl7YCkCgYEA8ibFJsUx1PJP0A3mmM2lzR7ZUSJBgbWu/pPEOynefAC0GKMczqf3To75AmhtoJWcQW2dDn1ALBn7wIdUN2R5K3yx5w7rgA5eK6s891Eehvm+w0q4lQ7pMytX2tsqU/gMQGCnedY1xsUKzX4G7zlsFvZjJJvdA5MTOt74Kmo9Z00CgYEAif/La98c94+yRbzgaiv1DM+WVUQ2tOaQfVWci95WH9A3HCXJnaXZvfNiUb8E8UNhErWZAE/NdfG5RlMq/TnLL0M8PaOKz5UijVJh9LZMjrbzd/+9D8FNuUH2TrGlWJc0aBvO1Opf+bsuq1RsZVPMJ9mku21temmoo6Ca06qkhlECgYEAoFQLNSBbXiMRtS9+/q0qmiVSveVwefFRbD1qL8IJDRFqLOXSrQGJPPps5Ks/6pMkYi2xT2aelpSdm1v+5q4fjCuDnvjB9IeO0lsOgrGzBKtXIvbWP9sfjEGmacGyxOX3NqjIOmMaOAE+pdBLxxi9+HYqLpMEQtmeYdw/c9Xj0gECgYBONR66Sb/XuMNsfpDBk8xwbaDSVB33zI0sO1T+ohQp/QcoAAwiVcHIpHF9c4EXn5OG7jxE/pG7SOZCYOqGxrKSOsbrVXvr4P6CKQJw0+Jm5RmEyQ/cH7yajbCRhHA89Ky8PnHJcwi7lNGiJtEM/IlOyKNoWSKHrhldFZoql6o6sQ==",
		
		//异步通知地址
		'notify_url' => "http://www.tpshop.com/home/order/notify",
		
		//同步跳转
		'return_url' => "http://www.tpshop.com/home/order/callback",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3lZaGCdNE5ajf82HxxPGa5utc+XY+ycLGsHjoen39tJTha2Zym6aX7rmMOEmZ0yvBmQDL1NOZNho/rGXPHxFNjqI1N6ZNklavDH/wWwTdgmpSHDNo04lNHjPkEDFi/NJkKxbSKZZpGB9n7nx/W/zzB4r2kocEaimHzzGDzdUbE7eQsjBTT02XcZ1ItqTVcs14N6OGVcu1ALpV2JKvtLorfB2tbBl5mM+Efq+gPj9cc7coq8PicVFxP57M21oqk48deRGnxxuaLJpLSRRN/S8FqDydsOjLnhW0clnqXMPXfjQhu9jOVEZ6YUi6wlWzQ7V3atmwpgiHX3nlzgunH4DBQIDAQAB",
);