(function() {
  "use strict";

  /**
  * Easy selector helper function
  */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
  * Easy event listener function
  */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
  * Easy on scroll event listener 
  */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
  * Sidebar toggle
  */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function(e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }
})();

  /**
  * Back to top button
  */
  let mybutton = document.getElementById("backTotop");    
  window.onscroll = function() {scrollFunction()};   
  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  } 
  function backTotopFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }

  /**
  * Navbar links active on scroll
  */
  const sections = document.querySelectorAll("section[id]");
  window.addEventListener("scroll", navHighlighter);
  function navHighlighter() {
    let scrollY = window.pageYOffset;
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 50;
      sectionId = current.getAttribute("id");
      if (
        scrollY > sectionTop &&
        scrollY <= sectionTop + sectionHeight
      ){
        document.querySelector(".navbar-nav a[href*=" + sectionId + "]").classList.add("active");
      } else {
        document.querySelector(".navbar-nav a[href*=" + sectionId + "]").classList.remove("active");
      }
    });
  }

  /**
  * Check All Check box
  */
  const checkallbox = document.getElementById("checkAll");
  const checkboxes = document.querySelectorAll('.productCheck');
  checkallbox.addEventListener("change", function () {
    const checkbox = this.checked;
    checkboxes.forEach(function (field) {
      field.checked = checkbox;
    });
  });

  /**
  * Enable Buttons Checkbox Selected
  */
  const checkAll = document.getElementById('checkAll');
  const productChecks = document.querySelectorAll('.productCheck');
  const deleteSelectedButton = document.getElementById('deleteSelected');
  const checkOutButton = document.getElementById('checkOut');
  function updateButtonStates() {
    const anyChecked = Array.from(productChecks).some(checkbox => checkbox.checked);
    deleteSelectedButton.disabled = !anyChecked;
    checkOutButton.disabled = !anyChecked;
  }
  checkAll.addEventListener('change', () => {
    productChecks.forEach(checkbox => checkbox.checked = checkAll.checked);
    updateButtonStates();
  });
  productChecks.forEach(checkbox => {
    checkbox.addEventListener('change', updateButtonStates);
  });
  updateButtonStates();