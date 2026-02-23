function togglePassword(inputId = "passwordInput") {
  const input = document.getElementById(inputId);
  if (!input) return;

  // SVG icons (modern UI)
  const eyeIcon = document.getElementById("eyeIcon");
  const eyeOffIcon = document.getElementById("eyeOffIcon");

  // Font Awesome icon (classic UI)
  const faIcon = input.parentElement.querySelector("i.fas, i.fa-solid");

  if (input.type === "password") {
    input.type = "text";

    // SVG toggle
    if (eyeIcon && eyeOffIcon) {
      eyeIcon.classList.add("hidden");
      eyeOffIcon.classList.remove("hidden");
    }

    // Font Awesome toggle
    if (faIcon) {
      faIcon.classList.remove("fa-eye");
      faIcon.classList.add("fa-eye-slash");
    }
  } else {
    input.type = "password";

    // SVG toggle
    if (eyeIcon && eyeOffIcon) {
      eyeOffIcon.classList.add("hidden");
      eyeIcon.classList.remove("hidden");
    }

    // Font Awesome toggle
    if (faIcon) {
      faIcon.classList.remove("fa-eye-slash");
      faIcon.classList.add("fa-eye");
    }
  }
}

// Auto-hide alert message after 5 seconds if it exists
const alertMsg = document.getElementById("alertMessage");
if (alertMsg) {
  setTimeout(() => {
    alertMsg.style.transition = "opacity 0.5s ease";
    alertMsg.style.opacity = "0";
    setTimeout(() => alertMsg.remove(), 500);
  }, 5000);
}

// menu togg;e

const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");

if (menuToggle && mobileMenu) {
  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");

    const icon = menuToggle.querySelector("i");
    if (icon) {
      icon.classList.toggle("fa-bars");
      icon.classList.toggle("fa-times");
    }
  });
}

// Borrow book

function openBorrowModal(id, title) {
  document.getElementById("modalBookId").value = id;
  document.getElementById("displayBookTitle").innerText = '"' + title + '"';
  document.getElementById("borrowModal").classList.remove("hidden");
  document.body.style.overflow = "hidden"; // Stop scrolling
}

function closeBorrowModal() {
  document.getElementById("borrowModal").classList.add("hidden");
  document.body.style.overflow = "auto"; // Restore scrolling
}

/**
 * Dismisses the alert with a smooth fade-out effect
 */
function dismissAlert() {
  const alert = document.getElementById("alertMessage");
  if (alert) {
    alert.classList.add("opacity-0");

    setTimeout(() => {
      alert.remove();
    }, 500);
  }
}

setTimeout(dismissAlert, 4000);

// index.php

document.addEventListener("DOMContentLoaded", function () {
  // Animated counters for statistics
  function animateCounter(elementId, finalValue, duration = 2000) {
    const element = document.getElementById(elementId);
    if (!element) return;

    let startValue = 0;
    const increment = finalValue / (duration / 16); // 60fps
    const timer = setInterval(() => {
      startValue += increment;
      if (startValue >= finalValue) {
        element.textContent = finalValue;
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(startValue);
      }
    }, 16);
  }

  // Initialize counters when in viewport
  function initCounters() {
    const statCards = document.querySelectorAll(".stat-card");
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            // Start counters
            setTimeout(() => {
              animateCounter("total-books", 2500);
              animateCounter("registered-users", 1200);
              animateCounter("books-issued", 850);
            }, 300);

            // Add animation class
            entry.target.classList.add(
              "animate__animated",
              "animate__fadeInUp"
            );
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    statCards.forEach((card) => observer.observe(card));
  }

  // Feature cards animation
  function initFeatureCards() {
    const featureCards = document.querySelectorAll(".feature-card");
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry, index) => {
          if (entry.isIntersecting) {
            setTimeout(() => {
              entry.target.style.opacity = "1";
              entry.target.style.transform = "translateY(0)";
            }, index * 100);
          }
        });
      },
      { threshold: 0.3 }
    );

    featureCards.forEach((card, index) => {
      card.style.opacity = "0";
      card.style.transform = "translateY(20px)";
      card.style.transition = "all 0.6s ease-out";
      card.style.transitionDelay = index * 0.1 + "s";
      observer.observe(card);
    });
  }

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80,
          behavior: "smooth",
        });
      }
    });
  });
  // Initialize all animations
  initCounters();
});
