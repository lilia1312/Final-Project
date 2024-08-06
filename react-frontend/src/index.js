import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from './SearchForm';
import SearchResults from './SearchResults';

ReactDOM.render(
  <React.StrictMode>
    <div>
      <SearchForm />
      <SearchResults />
    </div>
  </React.StrictMode>,
  document.getElementById('root')
);
