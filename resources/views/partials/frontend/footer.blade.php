<div class="bottom-contact">
    <a href="#" class="bottom-contact_link">
    	<i class="fa-brands fa-youtube"></i> 
        <span> Youtube</span>
    </a>
    <a href="#" class="bottom-contact_link">
        <i class="fa-brands fa-facebook"></i> 
        <span> Fanpage</span>
    </a>
    <a href="#" class="bottom-contact_link">
        <i class="icon-zalo"></i> 
        <span> Chat Zalo</span>
    </a>
    
</div>
<div>
	<a href="#" class="bottom-contact_link gotop">
        <i class="fa-solid fa-arrow-up"></i>
    </a>
</div>
<footer id="footer" class="footer-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 col-sm-12">
				<div class="footer-item">
					<p class="footer-item_title">Về chúng tôi</p>
					<ul class="footer-item_list">
						<li class="item_list">
							<img src="{{$setting->logo}}" alt="{{$setting->name}}">
						</li>
						<li class="item_list">
							<i class="fa-solid fa-location-dot"></i>
							<span>Trụ sở chính: {{$setting->address}}</span>
						</li>
						<li class="item_list">
							<i class="fa-solid fa-phone"></i>
							Điện thoại: <a href="tel:{{$setting->phone}}">{{$setting->phone}}</a>
						</li>
						<li class="item_list">
							<i class="fa-regular fa-envelope"></i>
							Email:<a href="mailto:{{$setting->phone}}">{{$setting->phone}}</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-12 col-md-4 col-sm-12">
				<div class="footer-item">
					<p class="footer-item_title">Map</p>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="footer-item">
					<p class="footer-item_title">Fan page</p>
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D61558070675634&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=2822072721330773" width="340" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
				</div>
			</div>
		</div>
	</div>
</footer>				
<div class="copyright bg-light">
	<div class="container">
		<div class="row">
			<p class="text-center">© 2025 {{config("APP_URL")}}. All rights reserved</p>
		</div>
	</div>
</div>			