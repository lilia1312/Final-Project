import React, { useEffect, useState } from 'react';

const SearchResults = () => {
  const [results, setResults] = useState([]);
  const urlParams = new URLSearchParams(window.location.search);
  const keyword = urlParams.get('keyword');

  useEffect(() => {
    if (keyword) {
      fetch(`/search.php?keyword=${encodeURIComponent(keyword)}`)
        .then((response) => response.json())
        .then((data) => setResults(data))
        .catch((error) => console.error('Error fetching search results:', error));
    }
  }, [keyword]);

  return (
    <div className="container mt-5">
      <h1>Search Results</h1>
      {results.length > 0 ? (
        <ul className="list-group">
          {results.map((result) => (
            <li key={result.id} className="list-group-item">
              <a href={`view.php?id=${result.id}`}>
                {result.title}
              </a>
            </li>
          ))}
        </ul>
      ) : (
        <p>No results found for "{keyword}"</p>
      )}
    </div>
  );
};

export default SearchResults;
