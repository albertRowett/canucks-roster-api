let collapsibles = document.querySelectorAll('.collapsible');
let length = collapsibles.length;

for (let i = 0; i < length; i++) {
    collapsibles[i].addEventListener('click', function() {
        this.classList.toggle('active');
        let content = this.nextElementSibling;
        let symbol = this.lastChild;

        if (content.style.display === 'block') {
            content.style.display = 'none';
            symbol.textContent = '\u002B';
        } else {
            content.style.display = 'block';
            symbol.textContent = '\u2212';
        }
    });
}

const link = document.querySelector('.returnAllNationalitiesLink');
link.addEventListener('click', handleLinkClick);

function handleLinkClick() {
    const collapsible = document.querySelector('#returnAllNationalities');
    collapsible.classList.add('active');
    const content = collapsible.nextElementSibling;
    content.style.display = 'block';
    const symbol = collapsible.lastChild;
    symbol.textContent = '\u2212';
}
