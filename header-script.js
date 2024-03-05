    let searchBtn = document.querySelector('.searchBtn');
    let closeBtn = document.querySelector('.closeBtn');
    let searchBox = document.querySelector('.searchBox');
    let navigation = document.querySelector('.navigation');
    let toggleMenu = document.querySelector('.menuToggle');
    let header = document.querySelector('header');

    searchBtn.onclick = function () {
        searchBox.classList.add('active');
        closeBtn.classList.add('active');
        searchBtn.classList.add('active');
        toggleMenu.classList.add('hide');

    }
    closeBtn.onclick = function () {
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        toggleMenu.classList.remove('hide');

    }

    toggleMenu.onclick = function () {
        header.classList.toggle('open');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        toggleMenu.classList.remove('active');
    }
