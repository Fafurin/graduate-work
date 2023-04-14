import axios from "axios";
import { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";

export default function EditBookFormat() {

    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const {id} = useParams();

    useEffect(() => {
        getBookFormat();
    });

    function getBookFormat() {
        axios.get(process.env.REACT_APP_API_URL + `/book-format/${id}/get`).then(function (response){
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

        axios.put(process.env.REACT_APP_API_URL + `/book-format/${id}/update`, inputs).then(function (response){
            console.log(response.data);
            navigate('/book-formats');
        });
    }

    return (
        <div className="row">
            <div className="col-3"></div>
            <div className="col-6">
                <h1>Edit book format</h1>
                <form onSubmit={ handleSubmit }>
                    <div className="mb-3">
                        <label>Title</label>
                        <input type="text" value={ inputs.title } className="form-control" name="title" onChange={ handleChange }/>

                        <label>Size</label>
                        <input type="text" value={ inputs.size } className="form-control" name="size" onChange={ handleChange }/>
                    </div>
                    <button type="submit" name="add" className="btn btn-primary">Edit</button>
                </form>
            </div>
            <div className="col-3"></div>
        </div>
    )
}
