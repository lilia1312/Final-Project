import React, { useState } from 'react';

const SearchForm = () => {
  const [keyword, setKeyword] = useState('');

  const handleSubmit = (event) => {
    event.preventDefault();
    window.location.href = `/search.php?keyword=${encodeURIComponent(keyword)}`;
  };

  return (
    <form className="d-flex" onSubmit={handleSubmit}>
      <input
        className="form-control me-2"
        type="search"
        placeholder="Search"
        aria-label="Search"
        value={keyword}
        onChange={(e) => setKeyword(e.target.value)}
        required
      />
      <button className="btn btn-outline-success" type="submit">Search</button>
    </form>
  );
};

export default SearchForm;
