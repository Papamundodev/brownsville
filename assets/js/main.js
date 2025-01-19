document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded');
  /**
   * header.php 
   * Header toggle
   */
  const headerToggleBtn = document.querySelector('.header-toggle');

  function headerToggle() {
    document.querySelector('#header').classList.toggle('header-show');
    headerToggleBtn.classList.toggle('bi-list');
    headerToggleBtn.classList.toggle('bi-x');
  }
  headerToggleBtn.addEventListener('click', headerToggle);

  /**
   * navbar.php
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });


   /**
    * Preloader
    * if page has selector .page-preloaderthen the preloader will appear for 1000ms
    * if not , then no loader will be shown 
    */
   const preloader = document.querySelector('#preloader');
   const pagePreloader = document.querySelector('.page-preloader');
   if (preloader && pagePreloader) {
     setTimeout(() => {
       preloader.remove();
     }, 500);
   }else{
    preloader.remove();
   }

      /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);


    /**
   * Init swiper sliders
   */
    function initSwiper() {
      document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
        let config = JSON.parse(
          swiperElement.querySelector(".swiper-config").innerHTML.trim()
        );
  
        if (swiperElement.classList.contains("swiper-tab")) {
          initSwiperWithCustomPagination(swiperElement, config);
        } else {
          new Swiper(swiperElement, config);
        }
      });
    }
  
    window.addEventListener("load", initSwiper);

      /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

   /**
   * Navmenu Scrollspy
   */
   let navmenulinks = document.querySelectorAll('.navmenu a');

   function navmenuScrollspy() {
     navmenulinks.forEach(navmenulink => {
       if (!navmenulink.hash) return;
       let section = document.querySelector(navmenulink.hash);
       if (!section) return;
       let position = window.scrollY + 200;
       if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
         document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
         navmenulink.classList.add('active');
       } else {
         navmenulink.classList.remove('active');
       }
     })
   }
   window.addEventListener('load', navmenuScrollspy);
   document.addEventListener('scroll', navmenuScrollspy);
});
