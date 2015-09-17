# generic-eCommerce-website
This is the php code for an generic eCommerce website built upon Yii framework 1.1.16, along with MySQL model file for database schemas. This version can be quickly modified to be used for most applications of eCommerce. The website has been inspired by www.jabong.com and www.flipkart.com. The comments can be seen inside code. Features available in current version are :

1- Website is based on Yii framework 1.1.16 http://www.yiiframework.com/. As per the reputation of the framework, the website is fast, scalable and extensible.

2- The website uses Bootstrap( http://getbootstrap.com/)  and highly customized css and is mobile compatiable. Using webview/ chromeview same website can be used as Android App with zero changes.

3- All cookies and passwords in website are either HMACed or encrypted.

4- The website has already integrated Mandrill transactional email APIs ( https://www.mandrill.com/ ) and SpringEdge transactional sms for India APIs ( http://springedge.com/ ).

5- The cart is HMACed cookie based and db based too. The cart is auto-correcting i.e. it updates itself in case of non-availability of a item due to its selected quantity and locality etc.

6- Item are associated to localities and tags. The localities and tags are dynamic and can be entered and fetched from db directly.

TODO:

1- Save phone number with user id in phone table if not exists already during checkout.

2- Complete coupon code logic in AppCommonCoupon.php.

3- In CartController.php checkout second stage:

a- Make back button usable using popState event.

b- Change item value in price time table and cart after order completion.

c- Email/ sms chef to inform order details based on one's sms_email_settings.

d- Add javascript to update the second screen form at client side on delivery time selection and entering coupon code.

4- Complete the review feature on every dish and aggregate the reviews to chefs.

5- Make a http://schema.org consistent page for every user's and dish's profile showing reviews, dishes by chef etc.

6- Complete dashboard for customer care center and chef for tracking orders.

7- Deep Integration of Google Analytics.

http://foodiesfeed.com/homemade-turkish-gozleme/
