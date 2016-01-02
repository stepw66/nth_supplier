<footer>
	 <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h5 class="white-text">ระบบเบิกพัสดุ โรงพยาบาลโนนไทย</h5>
            <p class="grey-text text-lighten-4">
                คุณสามารถเบิกพัสดุผ่าน ระบบเบิกพัสดุ ได้ตามกำหนดเวลาที่ทางเจ้าหน้าที่พัสดุกำหนด
                (ระบบแสดงผลได้ทุกขนาดหน้าจอ, ใช้งานได้ดีบน Google-Chrome และ Firefox และ IE 10+)
            </p>
          </div>
          <div class="col-md-6">
            <h5 class="white-text">เมนู</h5>
            <ul class="list-unstyled">
              <li><a class="grey-text text-lighten-3" href="{!! url('/') !!}">Dashboard</a></li>
              <li><a class="grey-text text-lighten-3" href="{!! route('issue.index') !!}">เบิกพัสดุ</a></li>   
              <li><a class="grey-text text-lighten-3" href="{!! route('receive.index') !!}">รับพัสดุ</a></li>    
              <li><a class="grey-text text-lighten-3" href="{!! route('store.index') !!}">คลังพัสดุ</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
            © 2015 ThemeSanasang, All rights reserved.     
        </div>
      </div>
</footer>

