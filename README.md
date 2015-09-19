# generic-eCommerce-website
###Features:
This is the php code for an generic eCommerce website built upon Yii framework 1.1.16, along with MySQL model file for database schemas. This version can be quickly modified to be used for most applications of eCommerce. The website has been inspired by www.jabong.com and www.flipkart.com. The comments can be seen inside code. Features available in current version are :

1- Website is based on Yii framework 1.1.16 http://www.yiiframework.com/. As per the reputation of the framework, the website is fast, scalable and extensible.

2- The website uses Bootstrap( http://getbootstrap.com/) and highly customized css and is mobile compatible. Using webview/ chromeview same website can be used as an Android App with zero changes.

3- All cookies and passwords in website are either HMACed or encrypted.

4- The website has already integrated Mandrill transactional email APIs ( https://www.mandrill.com/ ) and SpringEdge transactional sms for India APIs ( http://springedge.com/ ).

5- The cart is HMACed cookie and db based, and is restored after the browser restart. The cart is auto-correcting i.e. it updates itself in case of non-availability of a item due to its selected quantity and locality etc.

6- The website recognises mobile and desktop browsers, coupons and session expiration depends on these too.

7- The CSRF token is saved in session variable instead os cookie.

8- The session is saved in db to enable horizontal scaling, session can be easily configured to be saved in memory dbs like redis etc..

9- Role based accesses are present. Currently Admin, moderator, chef and customer are present with decreasing order of rights.

10- SEO optimised and human readable urls are used like :

http://xyz.com/tiffin/index/filters/location=cessna%20business%20park%7Csort=price%20increasing%7Cdate-start=2015-09-19%2018:48:46%7Cdate-end=2017-05-11%2018:48:46%7Ctags=south%20indian,sweet,%7Cchefs=chulha_15,%7C
http://xyz.com/tiffin/view/id/North+Big+Bucket+Meal-11

11- 'tiffin/index' page is loaded dynamically based on query created by url's parameters.
http://xyz.com/tiffin/index/filters/location=cessna%20business%20park%7Csort=price%20increasing%7Cdate-start=2015-09-19%2018:48:46%7Cdate-end=2017-05-11%2018:48:46%7Ctags=south%20indian,sweet,%7Cchefs=chulha_15,%7C

the css code, js code, js/ css files, html code are evaluated and loaded dynamically using JS at client side.

12- Complete website is supported in older version of IE and has been tested in IE 8 too. Pages like 'tiffin/index' which are dynamically changed support back/ forward button navigation of browser button using pop/ push state event in newer browsers and hash in older browsers as can be seen in a url copied from IE8 below:

http://xyz.com/tiffin/index/filters/location=Cessna%20Business%20Park#location=cessna business park|sort=price increasing|date-start=2015-09-19 18:55:55|date-end=2017-05-11 18:55:55|tags=south indian,|chefs=lunch corp_16,|

The urls from new or old browsers are supported accross each other.

13- Every input is sanitized and checked for Sql injection or other attacks.

14- Various code components are present to :

	a- Dynamically parse JSON containing html, css, js code and css, js files at client side to create new page or page's component.
	
	b- Handling role based accesses. Access/ permission changes are configurable and can be done within seconds.
	
	c- Handling request for AJAX response to send complete page a JSON below :
	
	{'html_code'=>'lorem ipsum', 'js_code'=>'lorem ipsum', 'css_code'=>'lorem ipsum',  'js_files'=>array('lorem ipsum'), 'css_files'=>array('lorem ipsum') }
	
	d- Coupon code component to roll out any new discount or cashback coupon codes within seconds the module handles the dynamic verification rules based on pre-programmed logic.
	
	e- Wallet component handles the closed wallet present in website. The wallet is centralized i.e. every discount coupon or online payment creates an entry in wallet and thus every transaction and order is acted upon by wallet. The credit entries in wallet is attached with an expiration date so that credited money can be used till specified expiration time.
	
	f- The wallet db table entries includes a HMAC entry based on user defined salt key as another layer of data protection.

15- Every operations on cart is handled on server side after all validations, including HMACed cart cookie's modifications. Each such operation reponds with a JSON string and this response is handled at client side.

16- The order numbers used are guaranteed to be unique, is generated once at start of each checkout process, can be easily remembered by human and do not leak any information like number of orders per day by website.

17- Order creation/ checkout process features are:

	a- Order creation/ checkout process is divided in two stages to simplify the order creation process.
	
	b- Checkout state exclusively belongs to a user and a HMACed url is assigned to it. This url can resurrect the checkout process at first stage of checkout. And thus can be used in cart abandonment email.
	
		HMACed url example:
		
		http://xyz.com/cart/checkout/id/65a2378dacaed6d628b2c5ff796699acf8935d0eAnkit%20Bisht_20X61
	
	c- Multiple phone numbers and addresses can be added by a user and any one can be used during a checkout. And, cart changes according to the selected address as every item is not available at every locality. Order is modified automicatically after notifying user based on selected address.
	
	d- As every item is associated with multiple delivery time at different price. In second stage delivery time can be selected for every item.
	
	f- Coupon code and wallet money can be used in second stage.
	
	g- A order can also be payed partially by wallet. However, remaining amount has to be paid by another payment method.
	
	h- Order creation/ checkout process has been architected to support online payment. Backend code is present for such method. However, APIs for any online payment solution provider has not been integrated.
	
	i- Order creation/ checkout process is highly secure and validates every input at server side also. DOM-modification at client side, filling invalid values or not filling fields are all handled at server side.
	
	j- After order completion a sms and email is sent containing HMACed url to view the complete details of order. Example url : http://xyz.com/cart/checkout/id/65a2378dacaed6d628b2c5ff796699acf8935d0eAnkit%20Bisht_20X61
	
18- A chef can create his own tiffin/ item and can attach tags, price, selling time period and delivery time to it.

19- DB also contains columns to support automated delivery boy assignment logic. As every order is assigned to a delivery boy and also delivery boy can accept or reject an order.   

20- Every chef is associated to many localities so the item created by them are only available in their associated localities. 

21- Each item can have multiple availability time period slots and can be order between those periods only.

22- Each item can have multiple delivery time and each delivery time has a price and quantity assigned to it. User selects the delivery time during checkout and pays price belonging to the selected delivery time slot. 

23- A item cannot be ordered if the demanded quantity exceeds the quantity associated with the selected delivery time. 

24- The localities and tags available in website are dynamic and can be entered to db by administrators.



###TODO:

1- Save phone number with user id in phone table if not exists already during checkout.

2- Complete coupon code logic in AppCommonCoupon.php.

3- In CartController.php checkout second stage:

	a- Make back button usable using popState event.

	b- Change item value in price time table and cart after order completion.

	c- Email/ sms chef to inform order details based on one's sms_email_settings.

	d- Add javascript to update the second screen form at client side on delivery time selection and entering coupon code.

4- Complete the review/ rating feature on every dish and aggregate the reviews to chefs.

5- Make a http://schema.org consistent page for every user's and dish's profile showing reviews/ rating, dishes by chef etc.

6- Complete dashboard for customer care center and chef for tracking orders.

7- Deep Integration of Google Analytics.

8- Listing of items should list items under next available slot/ pricetime record( if any), if available items in current slot/ pricetime record goes zero. Sold out should be shown only when all currently available slots/ pricetime record has zero available items.

9- Integrate messaging queue and delegate email, sms and inter-component communication to it. First move towards SOA( Service oriented architecture).

10- Add code to send cart abandonment email.


###DEMO:

Demo images/ videos of website can be found inside 'demo video' folder.

Currently, this code is running at http://128.199.200.150/1/retoss/index.php . However, this demo will be removed from the url soon.



###Landing page background image:

http://foodiesfeed.com/homemade-turkish-gozleme/

