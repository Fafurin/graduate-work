import './App.css';
import {BrowserRouter, Routes, Route, Link} from "react-router-dom";
import ListBookType from './components/BookType/ListBookType';
import CreateBookType from './components/BookType/CreateBookType';
import EditBookType from './components/BookType/EditBookType';

function App() {
    return (
        <div className="container">
            <div className="App">
                <h1 className="page-header text-center">Publishing CRUD</h1>
                <BrowserRouter>
                    <Link to="/" className="btn btn-success">Book types</Link>
                    <Link to="book-type/create" className="btn btn-success">Add new book type</Link>
                    <Routes>
                        <Route index element={<ListBookType />}/>
                        <Route path="book-type/create" element={<CreateBookType />}/>
                        <Route path="book-type/:id/edit" element={<EditBookType />}/>
                    </Routes>
                </BrowserRouter>
            </div>
        </div>
    );
}

export default App;
