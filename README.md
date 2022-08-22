# Prisma Payway Magento 2

## M2 Versiones soportadas
* Magento 2.4+

## Dependencias Requeridas
- Modulo Prisma_Payway 

## Instalación
**Este módulo requiere Prisma_Payway y no debe instalarse de manera aislada y manual**
(Ver - [Prisma_Payway README](https://github.com/decidir/dec_magento#readme))

## Configuración

- Bancos
  - Promociones de Payway -> Admimistrar Bancos
    Aqui se darán de alta los Bancos pudiendo ingresar
    - Habilitar Banco (siempre debe estar habilitado)
    - Nombre del Banco
    - Logo
- Tarjetas de Crédito
    - Promociones de Payway -> Admimistrar Tarjetas de Crédito
      Aqui se darán de alta las Tarjetas de Crédito pudiendo ingresar
        - Habilitar Tarjeta (siempre debe estar habilitada)
        - Nombre de la Tarjeta
        - ID SPS -> ID de pago a enviar a Payway
        - ID NPS -> no utilizado actualmente
        - Logo
- Promociones / Planes de Cuotas
    - Promociones de Payway -> Admimistrar Promociones
      Aqui se darán de alta las Promociones o Planes de Pago,
      combinando Banco/Tarjeta,  pudiendo ingresar
        - Habilitar Promoción
        - Nombre de la Regla
        - Tarjeta a la que aplicará
        - Fecha de inicio de vigenta de la promoción
        - Banco al que aplicará
        - Prioridad
        - Fecha de fin de vigenta de la promoción
        - Días en los cuales estará vigente
        - Websites a los que aplica
        - Planes De cuotas
            - Cuota -> Valor mostrado en front y utilizado para calcular el monto de la misma
            - Coeficiente -> Intereses aplicables
            - TEA -> Valor informativo Informativo
            - CFT -> Valor informativo Informativo
            - Cuota que se Envia -> Valor de la cuota utilizado para enviar a DECIDIR
    
## Desinstalación
**Este módulo es parte de Prisma_Payway y debe desinstalarse conjuntamente**
Ver - [Prisma_Payway README](https://github.com/decidir/dec_magento#readme))
