// Navbar script
const menu = document.getElementById('menu');
const nav = document.getElementById('navList');
const signUp = document.getElementById('sign')
 
menu.addEventListener('click', ()=> {
  nav.classList.toggle('active');
  signUp.classList.toggle('active');
  if(menu.classList.contains('fa-bars')){
      menu.classList.remove('fa-bars');
      menu.classList.add('fa-xmark');
  } else {
      menu.classList.remove('fa-xmark');
      menu.classList.add('fa-bars');
  }
}); 

/* Smooth Scrolling */
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll(".nav-link");

/* Precise Scroll Spy */
window.addEventListener("scroll", () => {
  let current = "";
  const scrollPosition = window.scrollY || window.pageYOffset;

  sections.forEach((section) => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.offsetHeight;

    // We use a tighter 200px offset to ensure we only trigger 
    // when the section is actually near the top of the screen
    if (scrollPosition >= sectionTop - 200) {
      current = section.getAttribute("id");
    }
  });

  // Special case: If we are at the very bottom of the page, 
  // force "contact" to be the active link
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 2) {
    current = "contact"; 
  }

  navLinks.forEach((link) => {
    link.classList.remove("active");
    
    const href = link.getAttribute("href");
    if (href && href.includes('#')) {
      const linkId = href.split("#")[1];
      
      // Only the LAST matching section in the loop stays as 'current'
      if (current && linkId === current) {
        link.classList.add("active");
      }
    }
  });
});


const track = document.querySelector('.slider-track');
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');
const slides = document.querySelectorAll('.slide');

// Centralize the gap and card width calculation
const getLayoutInfo = () => {
  const slideWidth = slides[0].getBoundingClientRect().width;
  const gap = 20; // Must match your CSS gap
  return { slideWidth, gap };
};

const moveSlider = (direction) => {
  const { slideWidth, gap } = getLayoutInfo();
  const step = slideWidth + gap;
  
  // 1. Sync index with actual current scroll position
  // This prevents the "white space jump" after manual scrolling
  const currentScroll = Math.abs(new WebKitCSSMatrix(window.getComputedStyle(track).transform).m41);
  let currentIndex = Math.round(currentScroll / step);

  // 2. Update index based on button click
  if (direction === 'next' && currentIndex < slides.length - 3) {
    currentIndex++;
  } else if (direction === 'prev' && currentIndex > 0) {
    currentIndex--;
  }

  // 3. Apply the smooth transform
  track.style.transform = `translateX(-${currentIndex * step}px)`;
};

nextBtn.onclick = () => moveSlider('next');
prevBtn.onclick = () => moveSlider('prev');

window.addEventListener('resize', () => {
    moveSlider('prev'); 
    moveSellSlider('prev');
});


// Sell Slider Logic (Synced with Feature Slider logic)
const sellTrack = document.querySelector('.sell-box');
const sellCards = document.querySelectorAll('.box-content');

const getSellLayout = () => {
    if (sellCards.length === 0) return 0;
    // Measure the actual card width
    const cardWidth = sellCards[0].getBoundingClientRect().width;
    // Get the gap (2rem = 32px usually, but let's measure it)
    const style = window.getComputedStyle(sellTrack);
    const gap = parseFloat(style.gap) || 32; 
    return cardWidth + gap;
};

const moveSellSlider = (direction) => {
    if (sellCards.length === 0) return;

    const step = getSellLayout();
    
    // SYNC: Read the actual position from the matrix
    const style = window.getComputedStyle(sellTrack);
    const matrix = new WebKitCSSMatrix(style.transform);
    const currentX = Math.abs(matrix.m41);

    let currentIndex = Math.round(currentX / step);

    if (direction === 'next' && currentIndex < sellCards.length - 3) {
        currentIndex++;
    } else if (direction === 'prev' && currentIndex > 0) {
        currentIndex--;
    }

    sellTrack.style.transform = `translateX(-${currentIndex * step}px)`;
};

// Global functions for the HTML onclick attributes
window.moveRight = () => moveSellSlider('next');
window.moveLeft = () => moveSellSlider('prev');

document.querySelectorAll('.fa-heart').forEach(icon => {
  icon.addEventListener('click', () => {
    icon.classList.toggle('fa-solid');
    icon.classList.toggle('fa-regular');
    icon.style.color = icon.classList.contains('fa-solid') ? 'red' : 'white';
  });
});


// Filter section
function executeGlobalFilter() {
  const resultArea = document.getElementById('filterResultDisplay');
  const clearBtn = document.getElementById('clearFilterBtn');
  
  resultArea.innerHTML = '<p class="placeholder-text">Searching...</p>';
  resultArea.style.display = 'grid'; // Ensure it's visible

  let formData = new FormData();
  formData.append('type', document.getElementById('mainType').value);
  formData.append('city', document.getElementById('mainCity').value);
  formData.append('price', document.getElementById('mainPrice').value);

  fetch('fetch_filter.php', {
  method: 'POST',
  body: formData
})
.then(response => response.text())
.then(data => {
  resultArea.innerHTML = data;
  // Show the clear button once results are loaded
  clearBtn.style.display = 'block';
});
}

function clearFilters() {
  const resultArea = document.getElementById('filterResultDisplay');
  const clearBtn = document.getElementById('clearFilterBtn');
  const form = document.getElementById('globalFilterForm');

  // 1. Reset the form fields
  form.reset();

  // 2. Hide the results and clear button
  resultArea.innerHTML = '<p class="placeholder-text">Select filters and click search to see properties here.</p>';
  clearBtn.style.display = 'none';
}