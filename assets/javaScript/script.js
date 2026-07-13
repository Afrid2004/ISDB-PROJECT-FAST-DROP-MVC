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

//all submenus in manu function
let submenuToggler = document.querySelectorAll(".submenu_toggler");

submenuToggler.forEach((toggler) => {
  toggler.addEventListener("click", () => {
    toggler.classList.toggle("active");
  });
});

//show available rider
let allShowRidersBtn = document.querySelectorAll(".showRidersBtn");
let allRiderDiv = document.getElementById("allRiderDiv");
let riderModal = document.getElementById("riderModal");
if (allShowRidersBtn) {
  allShowRidersBtn.forEach((btn) => {
    let parcelId = btn.dataset.parcel;
    let districtId = btn.dataset.district;
    btn.addEventListener("click", async () => {
      toggleModal();
      await showRider(districtId, parcelId);
    });
  });
  function toggleModal() {
    riderModal.classList.toggle("opacity-0");
    riderModal.classList.toggle("pointer-events-none");
  }
  const showRider = async (id, parcelId) => {
    let html = "";
    try {
      let res = await fetch(`${BASE_URL}/api/rider/available?district=${id}`);
      let jsondata = await res.json();
      let alldata = jsondata.data || [];
      console.log(alldata);
      if (alldata.length <= 0) {
        allRiderDiv.innerHTML = `<tr><td class="p-3 text-amber-500 text-center bg-amber-500/20" colspan="5">No Rider found! Please try agin later.</td></tr>`;
        return;
      }

      alldata.map((data, index) => {
        return (html += `
            <tr>
              <td class="px-6 py-4">
                ${index + 1}
              </td>
              <td class="px-6 py-4">
                <div>
                  <p class="font-medium text-[17px]">${data.rider_name}</p>
                  <p>${data.rider_email}</p>
                </div>
              </td>
              <td class="px-6 py-4">
                ${data.rider_phone}
              </td>
              <td class="px-6 py-4">
                <p class="uppercase font-medium">${data.vehicle_type}</p>
              </td>
              <td class="px-5">
                <button onclick="assignRider(${parcelId}, ${data.id})"
                    class="px-3 flex items-center gap-1 py-2 rounded bg-teal-500 text-white hover:bg-teal-600 active:bg-teal-500 cursor-pointer justify-center">
                    <i class="fa-solid fa-user-check text-xs"></i> Assign Rider
                </button>
              </td>
            </tr>
        `);
      });

      allRiderDiv.innerHTML = html;
    } catch (error) {
      allRiderDiv.innerHTML = `${error.message}`;
    }
  };
}

const assignRider = async (parcelId, riderId) => {
  try {
    let res = await fetch(`${BASE_URL}/api/parcel/assignrider`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        parcel_id: parcelId,
        rider_id: riderId,
      }),
    });
    let data = await res.json();
    if (data.success) {
      alert("Rider Assigned Successfully");
      toggleModal();
      location.reload();
    }
  } catch (err) {
    console.log(err);
  }
};

let acceptParcelBtn = document.querySelectorAll(".accept_parcel");
let rejectParcelBtn = document.querySelectorAll(".reject_parcel");

if (acceptParcelBtn && rejectParcelBtn) {
  acceptParcelBtn.forEach((btn) => {
    btn.addEventListener("click", async () => {
      let parcel_id = btn.dataset.parcelid;
      let rider_id = btn.dataset.riderid;
      let parceldata = {
        parcel_id: parcel_id,
        rider_id: rider_id,
      };
      try {
        let res = await fetch(`${BASE_URL}/api/parcel/acceptparcel`, {
          method: "PATCH",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(parceldata),
        });
        let data = await res.json();
        if (data.success) {
          alert("Accepted Parcel. Work status updated to busy.");
        }
      } catch (error) {
        console.log(error.message);
      }
    });
  });

  rejectParcelBtn.forEach((btn) => {
    btn.addEventListener("click", async () => {
      let parcel_id = btn.dataset.parcelid;
      let rider_id = btn.dataset.riderid;
      let parceldata = {
        parcel_id: parcel_id,
        rider_id: rider_id,
      };
      try {
        let res = await fetch(`${BASE_URL}/api/parcel/rejectparcel`, {
          method: "PATCH",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(parceldata),
        });
        let data = await res.json();
        if (data.success) {
          alert("Accepted Parcel.");
          location.reload();
        } else {
          alert("Failed to accept parcel.");
        }
      } catch (error) {
        console.log(error.message);
      }
    });
  });
}

//status update
let statusBtn = document.querySelectorAll(
  ".pickup_parcel, .transit_parcel, .deliver_parcel",
);

if (statusBtn) {
  statusBtn.forEach((btn) => {
    btn.addEventListener("click", async () => {
      let status = "";
      let parcelId = btn.dataset.parcelid;
      if (btn.classList.contains("pickup_parcel")) {
        status = "picked_up";
      }
      if (btn.classList.contains("transit_parcel")) {
        status = "in_transit";
      }
      if (btn.classList.contains("deliver_parcel")) {
        status = "delivered";
      }

      let statusData = {
        parcel_id: parcelId,
        parcel_status: status,
      };

      await updateStatus(statusData);
    });
  });
}

const updateStatus = async (status) => {
  try {
    const res = await fetch(`${BASE_URL}/api/parcel/updatestatus`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(status),
    });
    const data = await res.json();
    if (data.success) {
      alert(`Updated parcel status to ${status.parcel_status}`);
    } else {
      alert("Failed to update status");
    }
  } catch (error) {
    console.log(error.message);
  }
};
