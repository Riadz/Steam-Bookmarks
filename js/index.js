window.onload = function() {
  //shrink header on scroll
  const header = document.getElementById('header-container');
  window.onscroll = () => {
    if (window.scrollY !== 0) header.classList.add('shrinked-header');
    else header.classList.remove('shrinked-header');
  };
};
