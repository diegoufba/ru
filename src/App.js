import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Funcionario from './pages/Funcionario';
import Teste from './pages/teste';
// import Test from './pages/test';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route exact path="/" element={<Funcionario  />} />
        <Route exact path="/teste" element={<Teste  />} />
        {/* <Route path="/about" element={<AboutPage />} />
        <Route path="/test" element={<Test />} /> */}
      </Routes>
    </BrowserRouter>
  );
}

export default App;
