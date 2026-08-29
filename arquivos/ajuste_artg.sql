UPDATE getar_artgch a
JOIN artgchtemp g ON g.cod = a.cod
SET a.nome = g.nome;