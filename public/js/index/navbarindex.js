fetch('/navbarindex.html')
.then(response => response.text())
.then(data => {
    document.querySelector('body').insertAdjacentHTML('afterbegin', data);
})
.catch(error => console.error('Error fetching navigation bar:', error));

