const anime = require("animejs");
const tippy = require("tippy.js");
const Mustache = require("mustache");
const iziToast = require("izitoast");
const imagesloaded = require("imagesloaded");
const { pageAccelerator } = require("page-accelerator");

// utilities
const get = (selector, scope) => {
  scope = scope ? scope : document;
  return scope.querySelector(selector);
};

const getAll = (selector, scope) => {
  scope = scope ? scope : document;
  return scope.querySelectorAll(selector);
};

const nav = get("nav");
const profile = get("#profile");
const loading = get("#loading");
const content = get("#content");
const toggle = get(".toggle");
const avatarAnimation = anime({
  targets: '#avatar #moon',
  rotate: '1turn',
  transformOrigin: "center center 0",
  duration: 5000
});
const showSidenavCategories = anime({
  targets: '#sidenav-categories li',
  translateY: [-10, 0],
  duration: 1200,
  opacity: [0,1],
  delay: function(el, i) {
    return i * 30;
  }
});

function isHidden(el) {
  return (el.offsetParent === null)
}

function removeLoadingScreen () {
  anime({
    targets: "#loading",
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    complete: () => {
      loading.style.display = "none";
    }
  });
}

// loading animation
anime({
  targets: '#morphing #moon',
  rotate: '1turn',
  transformOrigin: "center center 0",
  duration: 5000,
  loop: true
});

tippy('#profile', {
  size: 'small',
  placement: 'bottom',
})

// show loading screen if images loaded faster than 200ms
setTimeout(() => {
  imagesloaded(get("body"), () => {
    let tabs = getAll(".js-tab");
    let panes = getAll(".js-tab-pane");
    let sidenavCategoriesTrigger = get("#sidenav-categories-trigger");
    let sidenavCategories = get("#sidenav-categories");
    let sidenavIcon = get("#sidenav-icon");
    let books = getAll(".js-book");
    let mobileReoadTriggers = getAll(".mobile-home-trigger");

    removeLoadingScreen();

    // bind click event to sideNav
    sidenavCategoriesTrigger.addEventListener("click", sidenavClick);

    // bind click event to each tab
    for (var i = 0; i < tabs.length; i++) {
      tabs[i].addEventListener("click", tabClick);
    }

    for (let i = 0; i < mobileReoadTriggers.length; i++) {
      mobileReoadTriggers[i].addEventListener("click", event => {
        location.reload();
      })
    }

    // we used mustache to render popup template
    const popupTmpl = document.querySelector('#popup').innerHTML;
    Mustache.parse(popupTmpl);

    for (var i = 0; i < books.length; i++) {
      tippy(books[i], {
        content(ref) {
          const id    = ref.getAttribute('data-id');
          const title = ref.getAttribute('data-title');
          const desc  = ref.getAttribute('data-desc').substring(0, 100) + '...';
          const perc = ref.getAttribute('data-rating');
          const status_id = (userBooks && userBooks[id]) ? userBooks[id].status_id : false;

          return Mustache.render(popupTmpl, { id, title, desc, perc, status_id });;
        },
        allowHTML: true,
        placement: "right",
        theme: "light rounded",
        arrow: true,
        arrowTransform: "scaleX(1.3)",
        distance: 20,
        maxWidth: "200px",
        animation: "fade",
        trigger: "click",
        interactive: true,
      });
    }

    // disable/enable tippy if on mobile/desktop device
    // onUserInputChange = type => {
    //   const method = type === 'touch' || this.window.innerWidth < 768 ? 'disable' : 'enable';
    //   for (let i = 0; i < books.length; i++) {
    //     books[i]._tippy[method]();
    //   }
    // }

    function sidenavClick (event) {
      if (sidenavCategories.classList.contains("hidden")) {
        sidenavCategories.classList.remove("hidden");
        sidenavIcon.classList.remove("rotate");
        showSidenavCategories.restart();
      } else {
        sidenavCategories.classList.add("hidden");
        sidenavIcon.classList.add("rotate");
      }
    }

    // each click event is scoped to the tab_container
    function tabClick (event) {
      let clickedTab = event.target;
      let activePane = get(`#${clickedTab.getAttribute("data-tab")}`);

      // remove all active tab classes
      for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
      }

      // remove all active pane classes
      for (var i = 0; i < panes.length; i++) {
        panes[i].classList.remove('active');
      }

      // apply active classes on desired tab and pane
      clickedTab.classList.add('active');
      activePane.classList.add('active');
    }
  });
}, 1000);

get("#mobile-nav-trigger").addEventListener("click", event => {
  if (isHidden(nav)) {
    toggle.classList.add("open");
    nav.classList.remove("hidden");
  } else {
    toggle.classList.remove("open");
    nav.classList.add("hidden");
  }
});

get("#mobile-profile-trigger").addEventListener("click", event => {
  profile.classList.remove("hidden");
  profile.style.top = "63px";
  content.classList.remove("flex");
  content.classList.add("hidden");
  nav.classList.add("hidden");
  toggle.classList.remove("open");
});

// avatar animation
// get("#avatar").addEventListener("mouseenter", event => {
//   avatarAnimation.restart();
// }, false);

// get("#avatar").addEventListener("mouseleave", event => {
//   avatarAnimation.reverse();
// }, false);

function changeStatus(bookId, statusId) {
  const formData = new FormData();
  formData.append('book_id', bookId);
  formData.append('status_id', statusId);

  console.log(bookId, statusId);

  return fetch(`${ROOT}/change_status`, {
    method: "POST",
    body: formData
  })
  .then(res => {
    if (res.status == 401) throw new Error("Not Logged In");
    return res.json();
  })
}

function changeStatusHandler(el) {
  const bookId = el.getAttribute('data-book_id');
  const statusId = el.value;

  return changeStatus(bookId, statusId)
  .then(o => {
    return o
  });
}

window.popupChangeStatusHandler = function popupChangeStatusHandler(el, title) {
  return changeStatusHandler(el)
  .then((o) => {
    const bookE = get(`#book-${o.book_id}`);
    bookE._tippy.hide();
    const l = `<label for="" class="hidden sm:inline-block rounded-full ${readStatusColor[o.status_id]} text-white px-2 py-1/2 text-xs">
        ${readStatusCodes1[o.status_id]}
    </label>`;
    get('.js-status', bookE).innerHTML = l;
    iziToast.show({
      title: title,
      message: `Added to '${readStatusCodes[o.status_id]}'`,
      closeOnClick: true,
      close: false,
    });
  })
}

const elementsSelect = getAll('.js-change-status');
elementsSelect.forEach(s => {
  s.addEventListener('change', (e) => {
    const bookTitle = e.currentTarget.getAttribute('data-book_title');
    changeStatusHandler(e.currentTarget)
    .then(o => {
      iziToast.show({
        title: bookTitle,
        message: `Added to '${readStatusCodes[o.status_id]}'`,
        closeOnClick: true,
        close: false,
      });
    })
  });
});


function deleteStatus(bookId) {
  const formData = new FormData();
  formData.append('book_id', bookId);

  return fetch(`${ROOT}/delete_status`, {
    method: "POST",
    body: formData
  })
  .then(res => {
    return res.json();
  });
}

function removeElement(elementId) {
  // Removes an element from the document
  const element = document.getElementById(elementId);
  element.parentNode.removeChild(element);
}

const elementsDelBtn = document.querySelectorAll('.js-del-status');
elementsDelBtn.forEach(b => {
  b.addEventListener('click', (e) => {
    const bookId = e.currentTarget.getAttribute('data-book_id');
    const bookTitle = e.currentTarget.getAttribute('data-book_title');

    iziToast.question({
      title: bookTitle,
      message: `will be deleted from your list.`,
      onClosing(instance, toast, closedBy) {
        if (closedBy == 'button' || closedBy == 'drag') return;

        return deleteStatus(bookId)
        .then(o => {
          removeElement(`book-${bookId}`)
        });
      }
    });
  });
});

getAll('.js-submit-btn-toggle')
.forEach(b => {
  b.addEventListener('change', (e) => get('#submit-gen').hidden = false)
});

