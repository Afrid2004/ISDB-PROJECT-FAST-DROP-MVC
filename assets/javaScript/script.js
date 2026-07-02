// menu toggler
let mobileMenuModal = document.getElementById("mobileMenuModal"),
  menuSidebar = document.getElementById("menuSidebar");

const MobileMenuToggle = () => {
  mobileMenuModal.classList.toggle("menu-toogler");
  menuSidebar.classList.toggle("menu-sidebar-toggle");
};

// swipper js for hero slider
const swiper = new Swiper(".heroSwipper", {
  loop: true,
  autoplay: {
    delay: 5000,
  },
  pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

// on scroll animation scripts
let aboutSection = document.querySelector("#about"),
  whyChooseSection = document.querySelector("#why_choose"),
  animateServices = document.querySelectorAll(".animate-services"),
  portfolioElement = document.querySelectorAll(".portfolioElement"),
  trackingSection = document.querySelector(".trackingSection"),
  blogElements = document.querySelectorAll(".blogElements"),
  faqElements = document.querySelectorAll(".faqElements"),
  header = document.querySelector("#header"),
  logo = document.querySelector("#logo");

// header animation trigger
if (header && logo) {
  document.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      header.classList.add("scroll-header");
      logo.src = `${BASE_URL}/assets/images/logo_black.png`;
    } else {
      header.classList.remove("scroll-header");
      logo.src = `${BASE_URL}/assets/images/logo_white.png`;
    }
  });
}

const animationTriggerFunction = (
  targetSection = "",
  activeClass = "",
  threshold = 0,
) => {
  let observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          targetSection.classList.add(activeClass);
        }
      });
    },
    {
      threshold,
    },
  );
  if (targetSection) {
    observer.observe(targetSection);
  }
};

// about section animation
animationTriggerFunction(aboutSection, "scroll-about", 0.3);

// why choose section animation
animationTriggerFunction(whyChooseSection, "scroll-why-choose", 0.3);

// our sercices animation
animateServices.forEach((service) => {
  animationTriggerFunction(service, "scroll-services", 0.3);
});

//portfolio animation
portfolioElement.forEach((element) => {
  animationTriggerFunction(element, "scroll-portfolio", 0.3);
});

//tracking section
animationTriggerFunction(trackingSection, "scroll-tracking", 0.3);

//blogs animation
blogElements.forEach((element) => {
  animationTriggerFunction(element, "scroll-blog", 0.3);
});

// faq elements
faqElements.forEach((element) => {
  animationTriggerFunction(element, "scroll-faq", 0.3);
});

//video modal
let videoModal = document.getElementById("video_modal");

if (videoModal) {
  let iframe = videoModal.querySelector("iframe"),
    modalCloseButton = document.getElementById("modalCloseButton"),
    videoPlayButton = document.getElementById("videoPlayButton");
  function handleVideoModal(src = "") {
    if (videoModal.classList.contains("active-modal")) {
      videoModal.classList.remove("active-modal");
      iframe.src = "";
      return;
    }
    videoModal.classList.add("active-modal");
    iframe.src = src;
  }

  videoPlayButton.addEventListener("click", () => {
    handleVideoModal(
      "https://www.youtube.com/embed/FikkQTfbaOs?si=jmp2mfdXyQ0qoT62",
    );
  });
  videoModal.addEventListener("click", () => handleVideoModal());
  modalCloseButton.addEventListener("click", () => handleVideoModal());
}

// testomonial swipper
const reviewSwiper = new Swiper(".reviewSwiper", {
  loop: true,
  grabCursor: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  mousewheel: false,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
    dynamicMainBullets: 1,
  },
  mousewheel: false,
  spaceBetween: 20,
  keyboard: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

// faq toggle
let faqDivs = document.querySelectorAll(".faq-div");
faqDivs.forEach((faq, index) => {
  // always open the first faq
  if (index === 0) {
    faq.classList.add("active");
  }
  faq.addEventListener("click", () => {
    // if contains active class or not
    let isActive = faq.classList.contains("active");
    faqDivs.forEach((div) => {
      // remove all active class
      div.classList.remove("active");
    });
    if (!isActive) {
      // if not exist active class then add it
      faq.classList.add("active");
    }
  });
});

//show pass and hide pass
let allShowPassIcon = document.querySelectorAll(".showpassIcon");
allShowPassIcon.forEach((icon) => {
  let input = icon.parentElement.previousElementSibling;
  icon.addEventListener("click", () => {
    if (input.type === "password") {
      input.type = "text";
      icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.replace("fa-eye-slash", "fa-eye");
    }
  });
});

// profile menu toggler
const profileBtn = document.getElementById("userBtn");
const profileMenu = document.getElementById("userMenu");

if (profileBtn && profileMenu) {
  profileBtn.addEventListener("click", () => {
    profileMenu.classList.toggle("hidden");
  });

  document.addEventListener("click", (e) => {
    if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
      profileMenu.classList.add("hidden");
    }
  });
}
