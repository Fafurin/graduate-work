import axios from "axios";
import { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";

export default function EditBookType() {

    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const {id} = useParams();

    useEffect(() => {
        getBookType();
    });

    function getBookType() {
        axios.get(process.env.REACT_APP_API_URL + `/book-type/${id}/get`).then(function (response){
            console.log(response.data);
            setInputs(response.data)
        });
    }

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }
    const handleSubmit = (event) => {
        event.preventDefault();

        axios.put(process.env.REACT_APP_API_URL + `/book-type/${id}/update`, inputs).then(function (response){
            console.log(response.data);
            navigate('/book-types');
        });
    }

    return (
        <div className="row">
            <div className="col-3"></div>
            <div className="col-6">
                <h1>Edit book types</h1>
                <form onSubmit={ handleSubmit }>
                    <div className="mb-3">
                        <label>Title</label>
                        <input type="text" value={ inputs.title } className="form-control" name="title" onChange={ handleChange }/>
                    </div>
                    <button type="submit" name="add" className="btn btn-primary">Edit</button>
                </form>
            </div>
            <div className="col-3"></div>
        </div>
    )
}
