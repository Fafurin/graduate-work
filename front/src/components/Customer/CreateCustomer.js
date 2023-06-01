import axios from "axios";
import {useEffect, useState} from "react";
import { useNavigate } from "react-router-dom";

export default function CreateCustomer() {
    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const useValidation = (value, validations) => {
        const [isEmpty, setEmpty] = useState(true)
        const [minLengthError, setMinLengthError] = useState(false)
        const [maxLengthError, setMaxLengthError] = useState(false)
        const [inputValid, setInputValid] = useState(false)

        useEffect( () => {
            for (const validation in validations) {
                switch (validation) {
                    case 'minLength':
                        value.length < validations[validation] ? setMinLengthError(true) : setMinLengthError(false)
                        break;
                    case 'maxLength':
                        value.length > validations[validation] ? setMaxLengthError(true) : setMaxLengthError(false)
                        break;
                    case 'isEmpty':
                        value ? setEmpty(false): setEmpty(true)
                        break;
                }
            }
        }, [value, validations])

        useEffect( () => {
            if (isEmpty || maxLengthError || minLengthError) {
                setInputValid(false);
            } else {
                setInputValid(true);
            }
        }, [isEmpty, maxLengthError, minLengthError]);

        return {
            isEmpty,
            minLengthError,
            maxLengthError,
            inputValid
        }
    }

    const useInput = (initialValue, validations) => {
        const [value, setValue] = useState(initialValue)
        const [isDirty, setDirty] = useState(false)
        const valid = useValidation(value, validations)

        const onChange = (e) => {
            setValue(e.target.value)
            setInputs(values => ({...values, [e.target.name]: e.target.value}));
        }

        const onBlur = (e) => {
            setDirty(true)
        }

        return {
            value,
            onChange,
            onBlur,
            isDirty,
            ...valid
        }
    }

    const handleSubmit = (event) => {
        event.preventDefault();
        axios.post(process.env.REACT_APP_API_URL + '/customer/create', inputs).then(function (response){
            console.log(response.data);
            navigate('/customers');
        });
    };

    const name = useInput('', { isEmpty: true, minLength: 4, maxLength: 100 });
    const phone = useInput('', { isEmpty: true, minLength: 6, maxLength: 12 });
    const email = useInput('', { isEmpty: true, minLength: 6, maxLength: 50 });
    const contactPerson = useInput('', { isEmpty: true, minLength: 4, maxLength: 50 });

    return (
        <div className="row">
            <div className="col-3"></div>
            <div className="col-6">
                <h1>Create customer</h1>
                <form onSubmit={ handleSubmit }>
                    <div className="mb-3">
                        <label>Name</label>
                        { (name.isDirty && name.isEmpty) && <div style={{ color: "red" }}>Поле не может быть пустым</div> }
                        { (name.isDirty && name.minLengthError) && <div style={{ color: "red" }}>Имя должно быть длиннее 4 символов</div> }
                        <input value={ name.value } onChange={ e => name.onChange(e) } onBlur={ e => name.onBlur(e) } type="text" className="form-control" name="name"/>

                        <label>Phone</label>
                        { (phone.isDirty && phone.isEmpty) && <div style={{ color: "red" }}>Поле не может быть пустым</div> }
                        { (phone.isDirty && phone.minLengthError) && <div style={{ color: "red" }}>Номер телефона должен быть длиннее 6 символов</div> }
                        { (phone.isDirty && phone.maxLengthError) && <div style={{ color: "red" }}>Номер телефона должен быть короче 12 символов</div> }
                        <input value={ phone.value } onChange={ e => phone.onChange(e) } onBlur={ e => phone.onBlur(e) } type="text" className="form-control" name="phone"/>

                        <label>Email</label>
                        { (email.isDirty && email.isEmpty) && <div style={{ color: "red" }}>Поле не может быть пустым</div> }
                        { (email.isDirty && email.minLengthError) && <div style={{ color: "red" }}>Email должен быть длиннее 6 символов</div> }
                        <input value={ email.value } onChange={ e => email.onChange(e) } onBlur={ e => email.onBlur(e) } type="text" className="form-control" name="email"/>

                        <label>Contact Person</label>
                        <input value={ contactPerson.value } onChange={ e => contactPerson.onChange(e) } onBlur={ e => contactPerson.onBlur(e) } type="text" className="form-control" name="contactPerson"/>
                    </div>
                    <button disabled={ !name.inputValid && !phone.inputValid && !email.inputValid && !contactPerson.inputValid } type="submit" name="add" className="btn btn-primary">Save</button>
                </form>
            </div>
            <div className="col-3"></div>
        </div>
    )
}
