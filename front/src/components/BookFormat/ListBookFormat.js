import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function ListBookFormat() {

    const [bookFormats, setBookFormats] = useState([]);
    useEffect(() => {
        getBookFormats();
    }, []);

    function getBookFormats() {
        axios.get(process.env.REACT_APP_API_URL + '/book-formats').then(function (response){
            console.log(response.data.items);
            setBookFormats(response.data.items);
        });
    }

    const deleteBookFormat = (id) => {
        axios.delete(process.env.REACT_APP_API_URL + `/book-format/${id}/delete`).then(function (response){
            console.log(response.data);
            getBookFormats();
        });
    };

    return (
        <div className="row">
            <div className="col-12">
                <h1>List book formats</h1>
                <Link to="create" className="btn btn-success">Add new book format</Link>
                <table className="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Title</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        { bookFormats.map((bookFormat, key) =>
                            <tr key={key}>
                                <td>{bookFormat.id}</td>
                                <td>{bookFormat.title}</td>
                                <td>{bookFormat.size}</td>
                                <td>
                                    <Link to={`${bookFormat.id}/edit`} className="btn btn-success">Edit</Link>
                                    <button onClick={ () => deleteBookFormat(bookFormat.id) } className="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        ) }
                    </tbody>
                </table>
            </div>
        </div>
    )
}
