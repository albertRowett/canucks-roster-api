const collapsibles = document.querySelectorAll('.collapsible');

collapsibles.forEach(collapsible => {
    collapsible.addEventListener('click', function() {
        this.classList.toggle('active');
        const content = this.nextElementSibling;
        const symbol = this.lastChild;

        if (content.style.display === 'block') {
            content.style.display = 'none';
            symbol.textContent = '\u002B';
        } else {
            content.style.display = 'block';
            symbol.textContent = '\u2212';
        }
    });
});

const link = document.querySelector('.returnAllNationalitiesLink');

link.addEventListener('click', function() {
    const collapsible = document.querySelector('#returnAllNationalities');
    collapsible.classList.add('active');
    const content = collapsible.nextElementSibling;
    content.style.display = 'block';
    const symbol = collapsible.lastChild;
    symbol.textContent = '\u2212';
});
