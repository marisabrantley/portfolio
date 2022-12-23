const year = new Date().getFullYear();

const date = `&copy;${year} Marisa Brantley &verbar; All rights reserved.<br>Made with <span>♥</span> in California.`;

document.getElementsByTagName('footer')[0].innerHTML = date;