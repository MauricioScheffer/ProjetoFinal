// document.addEventListener('DOMContentLoaded', function () {
//     const pontosPopups = document.querySelectorAll('.fa-ellipsis');
//     const profileImgs = document.querySelectorAll('.profile-img');

//     pontosPopups.forEach(pontosPopup => {
//         pontosPopup.addEventListener('click', function (event) {
//             event.stopPropagation();
//             const popupId = 'pontinhos-popup-' + this.id.split('-').pop();
//             const popup = document.getElementById(popupId);
//             if (popup) {
//                 popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
//             }
//             closeOtherPopups(popupId);
//         });
//     });

//     profileImgs.forEach(profileImg => {
//         profileImg.addEventListener('click', function (event) {
//             event.stopPropagation();
//             const popupId = 'nav-popup-' + this.id.split('-').pop();
//             const popup = document.getElementById(popupId);
//             if (popup) {
//                 popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
//             }
//             closeOtherPopups(popupId);
//         });
//     });

//     document.addEventListener('click', function () {
//         document.querySelectorAll('.pontinhos-popup, .nav-popup').forEach(popup => {
//             popup.style.display = 'none';
//         });
//     });

//     function closeOtherPopups(openPopupId) {
//         document.querySelectorAll('.pontinhos-popup, .nav-popup').forEach(popup => {
//             if (popup.id !== openPopupId) {
//                 popup.style.display = 'none';
//             }
//         });
//     }
// });