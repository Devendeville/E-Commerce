const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');

// Exemple de données
const data = [
  { name: 'John Doe', email: 'john@example.com', phone: '555-1234' },
  { name: 'Jane Smith', email: 'jane@example.com', phone: '555-5678' },
  { name: 'Bob Johnson', email: 'bob@example.com', phone: '555-9012' },
];

searchForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const searchTerm = searchInput.value.toLowerCase();
  const filteredData = data.filter((item) => {
    return (
      item.name.toLowerCase().includes(searchTerm) ||
      item.email.toLowerCase().includes(searchTerm) ||
      item.phone.toLowerCase().includes(searchTerm)
    );
  });
  displayResults(filteredData);
});

function displayResults(results) {
  searchResults.innerHTML = '';
  if (results.length === 0) {
    searchResults.innerHTML = '<tr><td colspan="3">Aucun résultat trouvé</td></tr>';
  } else {
    results.forEach((result) => {
      const row = `
        <tr>
          <td>${result.name}</td>
          <td>${result.email}</td>
          <td>${result.phone}</td>
        </tr>
      `;
      searchResults.innerHTML += row;
    });
  }
}