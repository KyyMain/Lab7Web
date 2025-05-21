<div style="
    background: linear-gradient(135deg, #ffffff 0%, #f5f7fa 100%);
    border-radius: 12px;
    padding: 20px 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
">
    <h3 style="
        font-size: 1.3rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid rgba(37, 99, 235, 0.2);
        position: relative;
    ">
        <span style="position: relative; z-index: 1;">Artikel Terkini</span>
        <span style="
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 70px;
            height: 2px;
            background-color: #2563eb;
        "></span>
    </h3>
    <ul style="
        list-style-type: none;
        margin: 0;
        padding: 0;
    ">
        <?php foreach ($artikel as $row): ?>
                    <li style="
                                            margin-bottom: 12px;
                                            padding-bottom: 12px;
                                            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                                            transition: all 0.3s ease;
                                        ">
                        <a href="<?= base_url('/artikel/' . $row['slug']) ?>" style="
                                                display: block;
                                                color: #374151;
                                                font-size: 0.95rem;
                                                font-weight: 500;
                                                text-decoration: none;
                                                padding: 8px 12px;
                                                border-radius: 8px;
                                                transition: all 0.3s ease;
                                                position: relative;
                                                overflow: hidden;
                                                z-index: 1;
                                            "
                        onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#2563eb'; this.style.paddingLeft='18px'"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151'; this.style.paddingLeft='12px'">
                        <span style="
                                                    position: relative;
                                                    z-index: 2;
                                                "><?= $row['judul'] ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
        <?php if (empty($artikel)): ?>
            <li style="
                                text-align: center;
                                padding: 20px;
                                color: #6b7280;
                                font-style: italic;
                            ">Belum ada artikel</li>
        <?php endif; ?>
    </ul>
    <div style="
        margin-top: 15px;
        text-align: right;
    ">
        <a href="<?= base_url('/artikel') ?>" style="
                    display: inline-block;
                    font-size: 0.85rem;
                    color: #2563eb;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    padding: 5px 10px;
                    border-radius: 6px;
                " onmouseover="this.style.backgroundColor='rgba(37, 99, 235, 0.1)'; this.style.transform='translateX(3px)'"
            onmouseout="this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'">
            Lihat Semua Artikel &rarr;
        </a>
    </div>
    </div>