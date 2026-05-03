import React, { useEffect, useState } from 'react';

function App() {
    const [stores, setStores] = useState([]);
    const [items, setItems] = useState([]);
    const [newStoreName, setNewStoreName] = useState('');
    const [selectedStoreId, setSelectedStoreId] = useState(null);
    const [newItemName, setNewItemName] = useState('');
    const [newItemQty, setNewItemQty] = useState(1);
    const [editingItemId, setEditingItemId] = useState(null);
    const [editName, setEditName] = useState('');
    const [editQuantity, setEditQuantity] = useState(1);
    const [editChecked, setEditChecked] = useState(false);

    const API_BASE = 'http://localhost/project2/api';

    const loadStores = () => {
        fetch(`${API_BASE}/stores`)
            .then(res => res.json())
            .then(data => setStores(data))
            .catch(err => console.error(err));
    };

    const loadItems = (storeId) => {
        setSelectedStoreId(storeId);

        fetch(`${API_BASE}/stores/${storeId}/items`)
            .then(res => res.json())
            .then(data => setItems(data))
            .catch(err => console.error(err));
    };

    useEffect(() => {
        loadStores();
    }, []);

    const createStore = () => {
        if (!newStoreName.trim()) return;

        fetch(`${API_BASE}/stores`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: newStoreName })
        })
            .then(() => {
                setNewStoreName('');
                loadStores();
            })
            .catch(err => console.error(err));
    };

    const deleteStore = (id) => {
        fetch(`${API_BASE}/stores/${id}`, {
            method: 'DELETE'
        })
            .then(() => {
                if (selectedStoreId === id) {
                    setItems([]);
                    setSelectedStoreId(null);
                }
                loadStores();
            })
            .catch(err => console.error(err));
    };

    const createItem = () => {
        if (!selectedStoreId || !newItemName.trim()) return;

        fetch(`${API_BASE}/stores/${selectedStoreId}/items`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: newItemName,
                quantity: newItemQty,
                checked: 0
            })
        })
        .then(() => {
            setNewItemName('');
            setNewItemQty(1);
            loadItems(selectedStoreId);
        });
    };

    const deleteItem = (id) => {
        fetch(`${API_BASE}/items/${id}`, {
            method: 'DELETE'
        }).then(() => loadItems(selectedStoreId));
    };

    const toggleItem = (item) => {
        fetch(`${API_BASE}/items/${item.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: item.name,
                quantity: item.quantity,
                checked: item.checked ? 0 : 1
            })
        }).then(() => loadItems(selectedStoreId));
    };

    const startEditItem = (item) => {
        setEditingItemId(item.id);
        setEditName(item.name);
        setEditQuantity(item.quantity);
        setEditChecked(item.checked);
    };
    
    const cancelEdit = () => {
        setEditingItemId(null);
    };
    
    const saveEditItem = (id) => {
        fetch(`${API_BASE}/items/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: editName,
                quantity: editQuantity,
                checked: editChecked ? 1 : 0
            })
        })
            .then(() => {
                setEditingItemId(null);
                loadItems(selectedStoreId);
            })
            .catch(err => console.error(err));
    };

    return (
        <div style={{ padding: '20px' }}>
            <h1>Stores</h1>

            <input
                type="text"
                placeholder="New store name"
                value={newStoreName}
                onChange={(e) => setNewStoreName(e.target.value)}
            />
            <button onClick={createStore}>Add Store</button>

            <ul>
                {stores.map(store => (
                    <li key={store.id}>
                        <strong onClick={() => loadItems(store.id)} style={{ cursor: 'pointer' }}>
                            {store.name}
                        </strong>

                        {' '}
                        <button onClick={() => deleteStore(store.id)}>
                            Delete
                        </button>
                    </li>
                ))}
            </ul>

            {selectedStoreId && (
                <div>
                    <h1>Items</h1>

                    <input
                        placeholder="Item name"
                        value={newItemName}
                        onChange={(e) => setNewItemName(e.target.value)}
                    />

                    <input
                        type="number"
                        value={newItemQty}
                        onChange={(e) => setNewItemQty(Number(e.target.value))}
                    />

                    <button onClick={createItem}>Add Item</button>

                    <ul>
                        {items.map(item => (
                            <li key={item.id}>
                                {editingItemId === item.id ? (
                                    <div>
                                        <input
                                            value={editName}
                                            onChange={(e) => setEditName(e.target.value)}
                                            placeholder="Name"
                                        />

                                        <input
                                            type="number"
                                            value={editQuantity}
                                            onChange={(e) => setEditQuantity(Number(e.target.value))}
                                            style={{ width: '60px', marginLeft: '5px' }}
                                        />

                                        <label style={{ marginLeft: '10px' }}>
                                            Checked:
                                            <input
                                                type="checkbox"
                                                checked={editChecked}
                                                onChange={(e) => setEditChecked(e.target.checked)}
                                            />
                                        </label>

                                        <button onClick={() => saveEditItem(item.id)}>Save</button>
                                        <button onClick={cancelEdit}>Cancel</button>
                                    </div>
                                ) : (
                                    <div>
                                        <span onClick={() => toggleItem(item)} style={{ cursor: 'pointer' }}>
                                            {item.checked ? '✔ ' : ''}{item.name} (Qty: {item.quantity})
                                        </span>

                                        <button onClick={() => startEditItem(item)} style={{ marginLeft: '10px' }}>
                                            Edit
                                        </button>

                                        <button onClick={() => deleteItem(item.id)}>
                                            Delete
                                        </button>
                                    </div>
                                )}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default App;