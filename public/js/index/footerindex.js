fetch('/footerindex.html')
.then(response => response.text())
.then(data => {
    document.querySelector('body').insertAdjacentHTML('beforeend', data);
})
.catch(error => console.error('Error fetching footer:', error));
