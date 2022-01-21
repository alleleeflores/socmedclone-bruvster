// grabs classes or ids in html and passes it to a const var
const menuItems = document.querySelectorAll('.menu-item');

const msgNotif = document.querySelector('#messages-notifs');
const messages = document.querySelector('.messages');

const theme = document.querySelector('#theme-custom');
const modal = document.querySelector('.theme-custom');

const fontSize = document.querySelectorAll('.font-sizes span');
var root = document.querySelector(':root');

const palette = document.querySelectorAll('.colors span');

const bgLight = document.querySelector('.bg-lights');
const bgDark = document.querySelector('.bg-dark');


// removes the class active from all items
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active');
    })
}

menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active');

        if (item.id != 'notifs'){
            // if it isnt the notif selected, it will show nothing
            document.querySelector('.notif-popup').style.display = 'none';
        }
        else{
            // if it is the notif selected, it will show the notif-popup
            document.querySelector('.notif-popup').style.display = 'block';
            // hide the notif count
            document.querySelector('#notifs .notif-count').style.display = 'none';
        }
    })
})

// MESSAGES

const searchMsg = () => {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('message-search');
    filter = input.value.toUpperCase();
    ul = document.getElementById("msg-list");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        h5 = li[i].getElementsByTagName("h5")[0];
        txtValue = h5.textContent || h5.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
        } else {
        li[i].style.display = "none";
        }
    }
}

// highlights messages card
msgNotif.addEventListener('click', () => {
    // give the div messages a box shadow
    messages.style["boxShadow"] = '0 0 1rem var(--color-primary-green)';
    // hides the notif count
    msgNotif.querySelector('.notif-count').style.display = 'none';
    // box shadow disappears after 2 seconds
    setTimeout(() => {
        messages.style.boxShadow = 'none';
    }, 1500);
})

// THEME CUSTOMIZATION

const showModal = () => {
    modal.style.display = 'grid';
}

const hideModal = (e) => {
    if (e.target.classList.contains('theme-custom')){
        modal.style.display = 'none';
    }
}

modal.addEventListener('click', hideModal)
theme.addEventListener('click', showModal);

// CHOOSE FONT SIZE

//remove active class from spans
const removeActive = () => {
    fontSize.forEach(size => {
        size.classList.remove('active');
    })
}

fontSize.forEach(size => {
    // change font sizes through html
    size.addEventListener('click', () => {
        //call function
        removeActive();
        
        let fontSizes;
        //toggle the slider
        size.classList.toggle('active');

        if (size.classList.contains('font-size-1')){
            fontSizes = '10px';
            root.style.setProperty('----sticky-top-left', '5.4rem');
            root.style.setProperty('----sticky-top-right', '5.4rem');
        }
        else if (size.classList.contains('font-size-2')){
            fontSizes = '13px';
            root.style.setProperty('----sticky-top-left', '5.4rem');
            root.style.setProperty('----sticky-top-right', '-7rem');
        }
        else if (size.classList.contains('font-size-3')){
            fontSizes = '16px';
            root.style.setProperty('----sticky-top-left', '-2rem');
            root.style.setProperty('----sticky-top-right', '-17rem');
        }
        else if (size.classList.contains('font-size-4')){
            fontSizes = '19px';
            root.style.setProperty('----sticky-top-left', '-5rem');
            root.style.setProperty('----sticky-top-right', '-25rem');
        }
        else if (size.classList.contains('font-size-5')){
            fontSizes = '22px';
            root.style.setProperty('----sticky-top-left', '-12rem');
            root.style.setProperty('----sticky-top-right', '-35rem');
        }
    
        //change the font size of the html 16px to fontSizes
        document.querySelector('html').style.fontSize = fontSizes;
    })
})

// CHOOSE COLORS

//remove active class from colors
const removeActiveColor = () => {
    palette.forEach(chooseColor => {
        chooseColor.classList.remove('active');
    })
}


palette.forEach(color => {
    color.addEventListener('click', () => {
        //call function
        removeActiveColor();

        let primaryColor;

        if(color.classList.contains('color-1')){
            primaryColor = '#1DF301';
        }
        else if(color.classList.contains('color-2')){
            primaryColor = '#82FF06';
        }
        else if(color.classList.contains('color-3')){
            primaryColor = '#FF7200';
        }
        else if(color.classList.contains('color-4')){
            primaryColor = '#FF4501';
        }
        color.classList.add('active');

        root.style.setProperty('--color-primary-green', primaryColor);
    })
})

// CHOOSE BACKGROUND

let lightColor;
let whiteColor;
let darkColor;

//set property of lightness by passing the variables
const bgChange = () => {
    root.style.setProperty('--light-color-l', lightColor);
    root.style.setProperty('--white-color-l', whiteColor);
    root.style.setProperty('--dark-color-l', darkColor);
}

bgLight.addEventListener('click', () => {
    //add active class
    bgLight.classList.add('active');

    //remove active class from other bgs
    bgDark.classList.remove('active');

    //remove changes from local
    window.location.reload();
})

bgDark.addEventListener('click', () => {
    let textColor = '#FFFFFF';

    //change logo
    var logo = document.getElementById("logo");
    logo.src = "assets/img/logo/bruvster-logo-lightsout.png";

    darkColor = '95%';
    whiteColor = '10%';
    lightColor = '0%';
    root.style.setProperty('--color-black', textColor);

    //add active class
    bgDark.classList.add('active');

    //remove active class from other bgs
    bgLight.classList.remove('active');

    //call function to execute change
    bgChange();
})