Оптимизация таблиц

CREATE TABLE info (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) DEFAULT NULL,
    `desc` TEXT DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE data (
    id INT(11) NOT NULL AUTO_INCREMENT,
    date DATE DEFAULT NULL,
    value INT(11) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE link (
    data_id INT(11) NOT NULL,
    info_id INT(11) NOT NULL,
    PRIMARY KEY (data_id, info_id),
    FOREIGN KEY (data_id) REFERENCES data(id) ON DELETE CASCADE,
    FOREIGN KEY (info_id) REFERENCES info(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



Индексация


CREATE INDEX idx_link_data_id ON link(data_id);
CREATE INDEX idx_link_info_id ON link(info_id);



Оптимизация запроса

SELECT 
    d.id AS data_id,
    d.date,
    d.value,
    i.id AS info_id,
    i.name,
    i.`desc`
FROM link l
JOIN data d ON l.data_id = d.id
JOIN info i ON l.info_id = i.id;
