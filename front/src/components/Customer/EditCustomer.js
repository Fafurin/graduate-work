import axios from "axios";
import { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";

export default function EditCustomer() {

    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const {id} = useParams();

    useEffect(() => {
        getCustomer();
    }, []);

    function getCustomer() {
        axios.get(process.env.REACT_APP_API_URL + `/customer/${id}/get`).then(function (response){
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

        axios.put(process.env.REACT_APP_API_URL + `/customer/${id}/update`, inputs).then(function (response){
            navigate('/customers');
        });
    }

    return (
        <div className="row">
            <div className="col-3"></div>
            <div className="col-6">
                <h1>Edit customer</h1>
                <form onSubmit={ handleSubmit }>
                    <div className="mb-3">
                        <label>Name</label>
                        <input type="text" value={ inputs.name } className="form-control" name="name" onChange={ handleChange }/>

                        <label>Phone</label>
                        <input type="text" value={ inputs.phone } className="form-control" name="phone" onChange={ handleChange }/>

                        <label>Email</label>
                        <input type="email" value={ inputs.email } className="form-control" name="email" onChange={ handleChange }/>

                        <label>Contact Person</label>
                        <input type="text" value={ inputs.contactPerson } className="form-control" name="contactPerson" onChange={ handleChange }/>
                    </div>
                    <button type="submit" name="add" className="btn btn-primary">Edit</button>
                </form>
            </div>
            <div className="col-3"></div>
        </div>
    )
}
