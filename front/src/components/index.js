import { Link } from "react-router-dom";

export default function index() {

    return (
        <div className="row">
            <div className="col-12">
                <h1 className="page-header text-center">Publishing CRUD</h1>

                <Link to="/customers" className="btn btn-success">Customers</Link>
                <Link to="/book-types" className="btn btn-success">Book types</Link>
                <Link to="/book-formats" className="btn btn-success">Book formats</Link>
            </div>
        </div>
    )
}
