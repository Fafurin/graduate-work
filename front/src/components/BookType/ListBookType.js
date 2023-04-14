import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function ListBookType() {

    const [bookTypes, setBookTypes] = useState([]);
    useEffect(() => {
        getBookTypes();
    }, []);

    function getBookTypes() {
        axios.get(process.env.REACT_APP_API_URL + '/book-types').then(function (response){
            console.log(response.data.items);
            setBookTypes(response.data.items);
        });
    }

    const deleteBookType = (id) => {
        axios.delete(process.env.REACT_APP_API_URL + `/book-type/${id}/delete`).then(function (response){
            console.log(response.data);
            getBookTypes();
        });
    };

    return (
        <div className="row">
            <div className="col-12">
                <h1>List book types</h1>
                <Link to="create" className="btn btn-success">Add new book type</Link>
                <table className="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        { bookTypes.map((bookType, key) =>
                            <tr key={key}>
                                <td>{bookType.id}</td>
                                <td>{bookType.title}</td>
                                <td>
                                    <Link to={`${bookType.id}/edit`} className="btn btn-success">Edit</Link>
                                    <button onClick={ () => deleteBookType(bookType.id) } className="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        ) }
                    </tbody>
                </table>
            </div>
        </div>
    )
}
