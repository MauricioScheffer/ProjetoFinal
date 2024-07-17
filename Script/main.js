// SIDEBAR
const menuItems = document.querySelectorAll('.menu-item');

// MENSAGENS
// const messagesNotification = document.querySelector('#messages-notifications');
// const messages = document.querySelector('.messages');
// const message = messages.querySelectorAll('.message');
// const messageSearch = document.querySelector('#message-search');

// TEMA
const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span')
var root = document.querySelector(':root');
const colorPalette = document.querySelectorAll('.choose-color span');
const Bg1 = document.querySelector('.bg-1');
const Bg2 = document.querySelector('.bg-2');
const Bg3 = document.querySelector('.bg-3');
const logo = document.querySelector('#imagem');

// const pontos = document.querySelector('.edit-item');
// const editModal = document.querySelector('.pontinhos-popup');


// document.querySelector('label[for="backButton"]').addEventListener('click', function() {
//     window.history.back();
//   });

function mostrarSenha(){
    var inputPass = document.getElementById('senha')
    var btnShowPass = document.getElementById('btn-senha')


    if(inputPass.type === 'password'){
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    }else{
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
//                          SIDEBAR
// remover
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active');
    })
}

menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active');
        if(item.id != 'notifications'){
            document.querySelector('.notifications-popup').style.display = 'none';
        }else {
            document.querySelector('.notifications-popup').style.display = 'block';
            document.querySelector('#notifications . notification-count').style.display = 'none';
        }
    })
})

// MENSAGENS
// pesquisar outras conversas
// const searchMessage = () => {
//     const val = messageSearch.value.toLowerCase();
//     message.forEach(user => {
//         let name = user.querySelector('h5').textContent.toLowerCase();
//         if(name.indexOf(val) != -1){
//             user.style.display = 'flex';
//         }else{
//             user.style.display = 'none';
//         }
//     })
// }

// pesquisar conversa
// messageSearch.addEventListener('keyup', searchMessage);

// click
// messagesNotification.addEventListener('click', () => {
//     messages.style.boxShadow = '0 0 1rem var(--color-primary)';
//     messagesNotification.querySelector('.notification-count').style.display = 'none';
//     setTimeout(() => {
//         messages.style.boxShadow = 'none';
//     }, 5000);
// })

// TEMA CUSTOMIZADO
// abrir
const openThemeModal = () => {
    themeModal.style.display = 'grid';
}

// fechar
const closeThemeModal = (e) => {
    if(e.target.classList.contains('customize-theme')){
        themeModal.style.display = 'none';
    }
}
themeModal.addEventListener('click', closeThemeModal);
theme.addEventListener('click', openThemeModal);


// Perfil Nav
document.addEventListener('DOMContentLoaded', () => {
    const navThemes = document.querySelectorAll('.nav-theme');
    // const navPopups = document.querySelectorAll('.nav-popup');

    // Função para abrir o popup de navegação
    const openNavPopup = (e) => {
        e.stopPropagation(); // Evitar que o evento clique se propague
        closeAllNavPopups(); // Fechar todos os popups antes de abrir o atual
        const popup = e.currentTarget.querySelector('.nav-popup');
        if (popup) {
            popup.style.display = 'block';
        }
    };

    // Função para fechar todos os popups de navegação
    const closeAllNavPopups = () => {
        navPopups.forEach(popup => {
            popup.style.display = 'none';
        });
    };

    // Fechar popup ao clicar fora
    const closeNavPopup = (e) => {
        if (!e.target.closest('.nav-theme')) {
            closeAllNavPopups();
        }
    };

    // Adicionar eventos de clique a todos os itens de navegação
    navThemes.forEach(navTheme => {
        navTheme.addEventListener('click', (e) => {
            if (e.target.closest('.nav-theme')) {
                openNavPopup(e);
            }
        });
    });

    // Adicionar evento de clique ao documento para fechar o popup quando clicar fora
    document.addEventListener('click', closeNavPopup);
});





// fontes
const removeSizeSelector = () => {
    fontSizes.forEach(size => {
        size.classList.remove('active');
    })
}

fontSizes.forEach(size => {
    
    size.addEventListener('click', () => {
        removeSizeSelector();
        let fontSize;
        size.classList.toggle('active');

    if(size.classList.contains('font-size-1')){
        fontSize = '10px';
        root.style.setProperty('----sticky-top-left', '5.4rem');
        root.style.setProperty('----sticky-top-right', '5.4rem');
    } else if(size.classList.contains('font-size-2')){
        fontSize = '13px';
        root.style.setProperty('----sticky-top-left', '5.4rem');
        root.style.setProperty('----sticky-top-right', '-7rem');
    }else if(size.classList.contains('font-size-3')){
        fontSize = '16px';
        root.style.setProperty('----sticky-top-left', '-2rem');
        root.style.setProperty('----sticky-top-right', '-17rem');
    }else if(size.classList.contains('font-size-4')){
        fontSize = '19px';
        root.style.setProperty('----sticky-top-left', '-5rem');
        root.style.setProperty('----sticky-top-right', '-25rem');
    }else if(size.classList.contains('font-size-5')){
        fontSize = '22px';
        root.style.setProperty('----sticky-top-left', '-12rem');
        root.style.setProperty('----sticky-top-right', '-33rem');
    }

    document.querySelector('html').style.fontSize = fontSize;
})
})

const changeActiveColorClass = () => {
    colorPalette.forEach(colorPicker => {
        colorPicker.classList.remove('active')
    })
}

// CORES
colorPalette.forEach(color => {
    color.addEventListener('click', () => {
        let primary;
        changeActiveColorClass();
        if(color.classList.contains('color-1')){
            primaryHue = 252;
        }else if(color.classList.contains('color-2')){
            primaryHue = 52;
        }else if(color.classList.contains('color-3')){
            primaryHue = 352;
        }else if(color.classList.contains('color-4')){
            primaryHue = 152;
        }else if(color.classList.contains('color-5')){
            primaryHue = 202;
        }
        color.classList.add('active');
        root.style.setProperty('--primary-color-hue', primaryHue);
    })
})

// fundo tema
const changeBG = () => {
    root.style.setProperty('--light-color-lightness', lightColorLightness);
    root.style.setProperty('--white-color-lightness', whiteColorLightness);
    root.style.setProperty('--dark-color-lightness', darkColorLightness);
}

// Função para trocar o logo
const changeLogo = (theme) => {
    if (theme == 'light') {
        logo.src = 'img/LogoWhite.png';
    } else {
        logo.src = 'img/LogoBlack.png';
    }
}

Bg1.addEventListener('click', () => {
    darkColorLightness = '10%';
    whiteColorLightness = '100%';
    lightColorLightness = '95%';

    Bg1.classList.add('active');
    Bg2.classList.remove('active');
    Bg3.classList.remove('active');
    changeLogo('dark'); // Troca para o logo branco
    changeBG();
})

Bg2.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '20%';
    lightColorLightness = '15%';

    Bg2.classList.add('active');
    Bg1.classList.remove('active');
    Bg3.classList.remove('active');
    changeLogo('light'); // Troca para o logo branco
    changeBG();
})

Bg3.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '10%';
    lightColorLightness = '0%';

    Bg3.classList.add('active');
    Bg1.classList.remove('active');
    Bg2.classList.remove('active');
    changeLogo('light'); // Troca para o logo preto
    changeBG();
})

// // Perfil POPUP PROFILE
document.getElementById('profile-img').addEventListener('click', function() {
    const navPopup = document.getElementById('nav-popup');
    navPopup.style.display = navPopup.style.display === 'block' ? 'none' : 'block';
});

// PUBLICAÇÃO POPUP ...
document.getElementById('pontos-popup').addEventListener('click', function() {
    const pontosPopup = document.getElementById('pontinhos-popup');
    pontosPopup.style.display = pontosPopup.style.display === 'block' ? 'none' : 'block';
});

// document.addEventListener("DOMContentLoaded", function() {
//     // Toggle profile options
//     const profileButton = document.getElementById('profile-img');
//     const navPopup = document.getElementById('nav-popup');

//     profileButton.addEventListener('click', function() {
//         navPopup.classList.toggle('active');
//     });

//     // Close profile options if clicked outside
//     document.addEventListener('click', function(event) {
//         if (!profileButton.contains(event.target) && !navPopup.contains(event.target)) {
//             navPopup.classList.remove('active');
//         }
//     });

//     // Toggle post options
//     const postButtons = document.querySelectorAll('.pontos-popup');
//     postButtons.forEach(button => {
//         button.addEventListener('click', function(event) {
//             event.stopPropagation(); // Evita que o clique feche o popup imediatamente
//             const popup = this.closest('.edit-item').querySelector('.pontinhos-popup');
//             popup.classList.toggle('active');
//         });
//     });

//     // Fecha os popups se clicar fora deles
//     document.addEventListener('click', function(event) {
//         postButtons.forEach(button => {
//             const popup = button.closest('.edit-item').querySelector('.pontinhos-popup');
//             if (!button.contains(event.target) && !popup.contains(event.target)) {
//                 popup.classList.remove('active');
//             }
//         });
//     });
// });



// COMENTÁRIO POPUP ...
document.getElementById('comentario-popup').addEventListener('click', function() {
    const comentarioPopup = document.getElementById('comentario-popup-div');
    comentarioPopup.style.display = comentarioPopup.style.display === 'block' ? 'none' : 'block';
});