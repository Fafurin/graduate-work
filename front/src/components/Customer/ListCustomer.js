import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function ListCustomer() {

    const [customers, setCustomers] = useState([]);
    useEffect(() => {
        getCustomers();
    }, []);

    function getCustomers() {
        axios.get(process.env.REACT_APP_API_URL + '/customers').then(function (response){
            setCustomers(response.data.items);
        });
    }

    const deleteCustomer = (id) => {
        axios.delete(process.env.REACT_APP_API_URL + `/customer/${id}/delete`).then(function (response){
            getCustomers();
        });
    };

    return (
        <div className="row">
            <div className="col-12">
                <h1>List customers</h1>
                <Link to="create" className="btn btn-success">Add new customer</Link>
                <table className="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Contact Person</th>
                        </tr>
                    </thead>
                    <tbody>
                        { customers.map((customer, key) =>
                            <tr key={key}>
                                <td>{customer.id}</td>
                                <td>{customer.name}</td>
                                <td>{customer.phone}</td>
                                <td>{customer.email}</td>
                                <td>{customer.contactPerson}</td>
                                <td>
                                    <Link to={`${customer.id}/edit`} className="btn btn-success">Edit</Link>
                                    <button onClick={ () => deleteCustomer(customer.id) } className="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        ) }
                    </tbody>
                </table>
            </div>
        </div>
    )
}
