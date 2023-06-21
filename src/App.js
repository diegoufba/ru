import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Funcionarios from './pages/Funcionarios';
// import AboutPage from './pages/AboutPage';
// import Test from './pages/test';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route exact path="/" element={<Funcionarios  />} />
        {/* <Route path="/about" element={<AboutPage />} />
        <Route path="/test" element={<Test />} /> */}
      </Routes>
    </BrowserRouter>
  );
}

export default App;
