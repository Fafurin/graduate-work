import './App.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import ListBookType from './components/BookType/ListBookType';
import CreateBookType from './components/BookType/CreateBookType';
import EditBookType from './components/BookType/EditBookType';
import ListBookFormat from './components/BookFormat/ListBookFormat';
import CreateBookFormat from './components/BookFormat/CreateBookFormat';
import EditBookFormat from './components/BookFormat/EditBookFormat';
import Index from "./components";

function App() {
    return (
        <div className="container">
            <div className="App">
                <BrowserRouter>
                    <Routes>
                        <Route index element={<Index />}/>
                        <Route path="book-types" element={<ListBookType />}/>
                        <Route path="book-types/create" element={<CreateBookType />}/>
                        <Route path="book-types/:id/edit" element={<EditBookType />}/>

                        <Route path="book-formats" element={<ListBookFormat />}/>
                        <Route path="book-formats/create" element={<CreateBookFormat />}/>
                        <Route path="book-formats/:id/edit" element={<EditBookFormat />}/>
                    </Routes>
                </BrowserRouter>
            </div>
        </div>
    );
}

export default App;
