<div class="row footer">
   
  
<footer class="footer-content">

    <!-- Section: Social media -->
    <section class="social-media-container">

      <div class="socials-text">
        
        <a href="#" class="back-to-top-btn" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Назад">

          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up" viewBox="0 0 16 16">
            <path d="M3.204 11h9.592L8 5.519zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659"/>
          </svg>
          
        </a>  
      
        <span class="socials-text-2">Къде можете да ни откриете: </span>
      </div>
  

      <div>
        <a href="#" class="social-icons">
            <i class="fab fa-google socials-icon" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Google"></i>
        </a>

        <a href="#" class="social-icons">
          <i class="fab fa-facebook-f socials-icon" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Facebook"></i>
        </a>

        <a href="#" class="social-icons">
          <i class="fab fa-instagram socials-icon" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Instagram"></i>
        </a>
      </div>
       
    </section>

    <hr>
  

    <!-- Section: About us  -->
    <section class="about-us">
      <div class="about-us-container">

        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

            <h6 class="footer-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                </svg>
                
                За нас: 
            </h6>

            <p>
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Architecto voluptatem odit beatae cupiditate animi veniam sint officiis atque pariatur aperiam! Ex exercitationem voluptatem labore explicabo neque velit quod quia unde?
            </p>
          </div>

  

        <!-- Contacts -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

            <h6 class="footer-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                  </svg>
                  Контакти
            </h6>

            <p>
    
              <a href=mailto:“info@example.com” class="fas fa-envelope contacts-icons" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Изпратете съобщение" style= "font-size:12px;">   info@example.com</a>
            </p>

            <p>
              <a href=callto:“+ 359 00 000 0000”  class="fas fa-phone contacts-icons " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Обадете се" style="font-size: 12px;">   + 359 00 000 0000</a>
            </p>

          </div>

        </div>

      </div>
    </section>

  
    <!-- Copyright -->
    <div class="copyright-section">
     © <?php 
      $year = date('Y');
      echo $year;
      ?> Copyright:
      <a class="copyright-text" href="#">LitCrit.bg</a>
      ® All rights reserved 
    </div>

  </footer>
  
</div>



<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>


   <!-- Profile Picture Upload JS ? --> 
   <script>
        const imageUpload = document.getElementById('imageUpload');
        const previewImage = document.getElementById('previewImage');
        const dropAreaPFP = document.querySelector('.image-drop-area');

        imageUpload.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                  // alert(1);
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        dropAreaPFP.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropAreaPFP.classList.add('dragging');
        });

        dropAreaPFP.addEventListener('dragleave', function () {
            dropAreaPFP.classList.remove('dragging');
        });

        dropAreaPFP.addEventListener('drop', function (e) {
            e.preventDefault();
            dropAreaPFP.classList.remove('dragging');
            const file = e.dataTransfer.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

  